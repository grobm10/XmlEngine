<?php

/**
 * @author			David Curras
 * @version			February 5, 2013
 * @filesource		/Utils/File/Image.php
 */
class Image{

	const MIME_JPG = 'image/jpeg';
	const MIME_JPEG = 'image/jpeg';
	const MIME_PNG = 'image/png';
	const MIME_BMP = 'image/bmp';
	const MIME_GIF = 'image/gif';
	const POSITION_TOP_LEFT = 1;
	const POSITION_TOP_CENTER = 2;
	const POSITION_TOP_RIGHT = 3;
	const POSITION_MIDDLE_LEFT = 4;
	const POSITION_MIDDLE_CENTER = 5;
	const POSITION_MIDDLE_RIGHT = 6;
	const POSITION_BOTTOM_LEFT = 7;
	const POSITION_BOTTOM_CENTER = 8;
	const POSITION_BOTTOM_RIGHT = 9;

	/*
	 * The image full path
	 * @var	string
	 */
	private $path;

	/*
	 * The generic name (without file extension)
	 * @var	string
	 */
	private $name;
	
	/*
	 * The image width in px
	 * @var	int
	 */
	private $width;
	
	/*
	 * The image height in px
	 * @var	int
	 */
	private $height;
	
	/*
	 * Will be RGB or CMYK
	 * @var	int
	 */
	private $channels;
	
	/*
	 * The number of bits for each color
	 * @var	int
	 */
	private $bits;
	
	/*
	 * The correspondant MIME type of the image
	 * @var	string
	 */
	private $mime;
	
	/*
	 * The image identifier representing the image obtained from the path
	 * @var	resource
	 */
	private $gdImage;
	
	/**
	 * Creates an Image instance
	 * 
	 * @param	string	$path
	 */
	public function __construct($path=null){
		if(empty($path) || !file_exists($path)){
			throw new Exception('Unable to create Image object with empty or wrong path. Image->__construct');
		}
		$info = getimagesize($path);
		$this->path = $path;
		$this->name = File::GetNameWithoutExtension($path);
		$this->width = $info[0];
		$this->height = $info[1];
		$this->bits = $info['bits'];
		$this->mime = $info['mime'];
		if($this->mime == self::MIME_JPEG){
			$this->channels = $info['channels'] == 3 ? 'RGB' : 'CMYK';
		}
		$this->gdImage = $this->getImageFromFile();
		if(!$this->gdImage){
			throw new Exception('Unable to parse the image with GD. Image->__construct');
		}
	}
	
	/**
	 * Removes the image from memory
	 */
	public function __destruct(){
		imagedestroy($this->gdImage);
	}
	
	/**
	 * @return	string
	 */
	public function getPath(){
		return $this->path;
	}
	
	/**
	 * @return	string
	 */
	public function getWidth(){
		return $this->width;
	}
	
	/**
	 * @return	string
	 */
	public function getHeight(){
		return $this->height;
	}
	
	/**
	 * @return	string
	 */
	public function getChannels(){
		return $this->channels;
	}
	
	/**
	 * @return	string
	 */
	public function getBits(){
		return $this->bits;
	}
	
	/**
	 * @return	string
	 */
	public function getMime(){
		return $this->mime;
	}
	
	/**
	 * @return	string	$gdImage
	 */
	public function getGdImage(){
		return $this->gdImage;
	}
	
	/**
	 * Converts the file image into a gd
	 */
	public function getImageFromFile(){
		$image = false;
		switch ($this->mime) {
			case self::MIME_JPG:
			case self::MIME_JPEG:
				$image = imagecreatefromjpeg($this->path);
				break;
			case self::MIME_PNG:
				$image = imagecreatefrompng($this->path);
				break;
			case self::MIME_BMP:
				$image = imagecreatefromwbmp($this->path);
				break;
			case self::MIME_GIF:
				$image = imagecreatefromgif($this->path);
				break;
		}
		return $image;
	}
	
	/**
	 * Resizes the image to the given percentage keeping the aspect ratio
	 *
	 * @param	int		$width
	 * @param	int		$height
	 * @param	bool	$isPercentage
	 *
	 * @example	$image->resize(50); //Resizes to 50px width keeping the aspect ratio
	 * @example	$image->resize(50, 20, false); //Resizes to 50px width and 20px height changing the aspect ratio
	 * @example	$image->resize(50, null, true); //Resizes to 50% width keeping the aspect ratio
	 * @example	$image->resize(null, 20, false); //Resizes to 20px height keeping the aspect ratio
	 */
	public function resize($width=null, $height=null, $isPercentage=false){
		$width = intval($width);
		$height = intval($height);
		$currentAspectRatio = $this->width / $this->height;
		$keepAspectRatio = false;
		if(empty($width) && empty($height)){
			throw new Exception('Unable to resize image with empty width and height. Image->resize()');
		}
		//If only one value is given it keeps the aspect ratio, else will change the aspect ratio
		if((empty($width) && !empty($height)) || (!empty($width) && empty($height))){
			$keepAspectRatio = true;
		}
		if($isPercentage){
			//If keeps the aspect ratio with percentages just resize width and height with the same percentage
			if($keepAspectRatio){
				if(empty($height)){
					$height = $width;
				} else {
					$width = $height;
				}
			}
			//Convert percetages to pixels
			$width = $this->width * ($width/100);
			$height = $this->height * ($height/100);
		} else {
			//If keeps the aspect ratio with pixels needs to calculate the proper pixels for width and height
			if($keepAspectRatio){
				if(empty($height)){
					$height = intval($width / $currentAspectRatio);
				} else {
					$width = intval($currentAspectRatio * $height);
				}
			}
		}
		$destImage = ImageCreateTrueColor($width, $height);
		imagecopyresampled($destImage, $this->gdImage, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
		$this->gdImage = $destImage;
		$this->width = $width;
		$this->height = $height;
	}
	
	/**
	 * Resamples the image
	 *
	 * @param	int		$x
	 * @param	int		$y
	 * @param	int		$width
	 * @param	int		$height
	 * @param	int		$destWidth
	 * @param	int		$destHeight
	 * @example	$image->resample(50, 20, 100, 100, 200, 200);
	 */
	public function resample($x, $y, $width, $height, $destWidth=null, $destHeight=null){
		if(empty($width) || empty($height)){
			throw new Exception('Unable to resample image with empty width or height. Image->resample()');
		}
		if(empty($destWidth)){
			$destWidth = $width;
		}
		if(empty($destHeight)){
			$destHeight = $height;
		}
		$destImage = ImageCreateTrueColor($destWidth, $destHeight);
		imagecopyresampled($destImage, $this->gdImage, 0, 0, $x, $y, $destWidth, $destHeight, $width, $height);
		$this->gdImage = $destImage;
		$this->width = $destWidth;
		$this->height = $destHeight;
	}
	
	/**
	 * Rotates the image with the given angle
	 *
	 * @param	int		$angle
	 * @param	int		$gbColor
	 * @example	$image->rotate(50, array(20,255,0));
	 */
	public function rotate($angle, $gbColor=array(255,255,255)){
		$color = imagecolorallocate($this->gdImage, $gbColor[0], $gbColor[1], $gbColor[2]);
		imagecolortransparent($this->gdImage, $color);
		imagealphablending($this->gdImage,true);
		$rotate = imagerotate($this->gdImage, $angle, $color);
	}
	
	/**
	 * Adds a text watermark to the current image
	 *
	 * @param	string		$text
	 * @param	string		$ttfFile
	 * @param	int			$fontSize
	 * @param	int			$angle
	 * @param	array		$color
	 * @param	int			$position
	 * @param	int			$opacity
	 * @example	$image->addWatermark('GD', '/fonts/arial.ttf', 20, 0, array(0,255,186,100), Image::POSITION_BOTTOM_RIGHT);
	 */
	public function addTextWatermark($text, $ttfFile, $fontSize=20, $angle=0, $color=array(0,0,0,127), $position=Image::POSITION_BOTTOM_RIGHT, $opacity=100){
		if(empty($text) || empty($ttfFile) || !is_file($ttfFile)){
			throw new Exception('Unable to create text watermark with empty text or not valid TTF file. Image->addTextWatermark()');
		}
		if(count($color) == 3){
			$color[3] = 127; //add the alpha channel
		}
		$textBoxInfo = imagettfbbox($fontSize, 0, $ttfFile, $text);
		$plus = 0.4; //Add some margin pixels to the image
		$textWidth = intval($textBoxInfo[4] - $textBoxInfo[6]);
		$textHeight = intval($textBoxInfo[1] - $textBoxInfo[7]);
		$x = 0;
		$y = $textHeight;
		if(!empty($angle)){
			if($angle > 90)
				$angle = 90;
			if($angle < -90)
				$angle = -90;
			$newWidth = (cos(deg2rad(abs($angle)))*$textWidth) + (cos(deg2rad(90-abs($angle)))*$textHeight);
			$newHeight = (sin(deg2rad(abs($angle)))*$textWidth) + (sin(deg2rad(90-abs($angle)))*$textHeight);
			$textWidth = $newWidth;
			$textHeight = $newHeight;
			if($angle > 0){
				$x += intval(sin(deg2rad($angle))*23); //TODO: improve this proportion
				$y += intval(sin(deg2rad($angle))*85); //TODO: improve this proportion
			} else {
				$x += intval(sin(deg2rad($angle))*-12);
				$y += intval(sin(deg2rad($angle))*2);
			}
		}
		$textWidth = intval($textWidth*($plus+1));
		$textHeight = intval($textHeight*($plus+1));
		$textImage = imagecreatetruecolor($textWidth, $textHeight);
		$transparent = imagecolorallocate($textImage, 12, 34, 56);
		$black = imagecolorallocate($textImage, 0, 0, 0);
		imagecolortransparent($textImage, $transparent);
		imagealphablending($textImage,true);
		imagefilledrectangle($textImage, 0, 0, $textWidth, $textHeight, $transparent);
		imagettftext($textImage, $fontSize, $angle, $x, $y, $black, $ttfFile, $text);
		//Adding watermark
		$x = $marginX = 10;
		$y = $marginY = 10;
		if(($position == self::POSITION_TOP_CENTER) || ($position == self::POSITION_MIDDLE_CENTER) || ($position == self::POSITION_BOTTOM_CENTER)){
			$x = ($this->width - $textWidth) / 2;
		} elseif(($position == self::POSITION_TOP_RIGHT) || ($position == self::POSITION_MIDDLE_RIGHT) || ($position == self::POSITION_BOTTOM_RIGHT)){
			$x = $this->width - $textWidth - $marginX;
		}
		if(($position == self::POSITION_MIDDLE_LEFT) || ($position == self::POSITION_MIDDLE_CENTER) || ($position == self::POSITION_MIDDLE_RIGHT)){
			$y = ($this->height - $textHeight) / 2;
		} elseif(($position == self::POSITION_BOTTOM_LEFT) || ($position == self::POSITION_BOTTOM_CENTER) || ($position == self::POSITION_BOTTOM_RIGHT)){
			$y = $this->height - $textHeight - $marginY;
		}
		imagecopymerge($this->gdImage, $textImage, $x, $y, 0, 0, $textWidth, $textHeight, $opacity);
	}
	
	
	/**
	 * Adds a image watermark to the current image
	 *
	 * @param	Image		$watermark
	 * @param	int			$position
	 * @param	int			$opacity
	 * @example	$image->addImageWatermark(new Image('/img/myimage.jpg'), $position=Image::POSITION_MIDDLE_CENTER, 25);
	 */
	public function addImageWatermark($watermark, $position=Image::POSITION_BOTTOM_RIGHT, $opacity=100){
		$x = $marginX = 10;
		$y = $marginY = 10;
		if(($position == self::POSITION_TOP_CENTER) || ($position == self::POSITION_MIDDLE_CENTER) || ($position == self::POSITION_BOTTOM_CENTER)){
			$x = ($this->width - $watermark->getWidth()) / 2;
		} elseif(($position == self::POSITION_TOP_RIGHT) || ($position == self::POSITION_MIDDLE_RIGHT) || ($position == self::POSITION_BOTTOM_RIGHT)){
			$x = $this->width - $watermark->getWidth() - $marginX;
		}
		if(($position == self::POSITION_MIDDLE_LEFT) || ($position == self::POSITION_MIDDLE_CENTER) || ($position == self::POSITION_MIDDLE_RIGHT)){
			$y = ($this->height - $watermark->getHeight()) / 2;
		} elseif(($position == self::POSITION_BOTTOM_LEFT) || ($position == self::POSITION_BOTTOM_CENTER) || ($position == self::POSITION_BOTTOM_RIGHT)){
			$y = $this->height - $watermark->getHeight() - $marginY;
		}
		imagecopymerge($this->gdImage, $watermark->getGdImage(), $x, $y, 0, 0, $watermark->getWidth(), $watermark->getHeight(), $opacity);
		$transparent = imagecolorallocate($this->gdImage, 12, 34, 56);
		imagecolortransparent($this->gdImage, $transparent);
		imagealphablending($this->gdImage,true);
	}
	
	/**
	 * Exports the current image to the given mime format
	 *
	 * @param	$mimeType
	 * @param	$folderPath
	 * @example	$image->exportTo(Image::MIME_PNG, '/here/images/', 'gato');
	 */
	public function exportTo($mimeType=null, $folderPath=null, $imageName=null, $quality=100){
		if(empty($mimeType)){
			$mimeType = $this->mime;
		}
		if(empty($folderPath)){
			$folderPath = File::GetParentFolderPath($this->path, true) . 'GdImages/';
			if(!is_dir($folderPath)){
				mkdir($folderPath);
			}
		}
		if(empty($imageName)){
			$imageName = $this->name;
		}
		switch ($mimeType) {
			case self::MIME_JPG:
			case self::MIME_JPEG:
				return imagejpeg($this->gdImage, $folderPath.$imageName.'.jpg', $quality);
			case self::MIME_PNG:
				return imagepng($this->gdImage, $folderPath.$imageName.'.png');
			case self::MIME_GIF:
				return imagegif($this->gdImage, $folderPath.$imageName.'.gif');
			default:
				throw new Exception('Unable to export to '.$mimeType.' format. Image->exportTo().');
		}
	}
}