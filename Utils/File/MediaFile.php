<?php
/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/MediaFile.php
 * @see				http://ffmpeg-php.sourceforge.net/doc/api/index.php
 */

class MediaFile{
	
	const VIDEO = 'VIDEO';
	const AUDIO = 'AUDIO';
	
	private $mediaFile = null;
	private $mediaType = null;
	private $constantBitRate = null;
	public $error = '';

	/**
	 * 
	 * @param		string			$filePath
	 * @param		const			$mediaType
	 * @param		bool			$constantBitRate
	 */
	public function __construct($filePath, $mediaType, $constantBitRate=true){
		if (is_file($filePath)){
			$this->mediaFile = new ffmpeg_movie($filePath);
			$this->mediaType = $mediaType;
			$this->constantBitRate = $constantBitRate;
		} else {
			throw new Exception('Invalid file path "'.$filePath.'"');
		}
	}
	
	/** 
	 * Returns an array with all video or audio info 
	 * 
	 * @return		array|string
	 */
	public function getFullInfo(){
		$info = array();
		$info['duration'] = $this->mediaFile->getDuration();			//Return the duration of a movie or audio file in seconds.
		$info['frameCount'] = $this->mediaFile->getFrameCount();		//Return the number of frames in a movie or audio file.
		$info['filename'] = $this->mediaFile->getFilename();			//Return the path and name of the movie file or audio file.
		$info['comment'] = $this->mediaFile->getComment();			//Return the comment field from the movie or audio file.
		$info['title'] = $this->mediaFile->getTitle();				//Return the title field from the movie or audio file.
		$info['author'] = $this->mediaFile->getAuthor();				//Return the author field from the movie or the artist ID3 field from an mp3 file.
		$info['copyright'] = $this->mediaFile->getCopyright();		//Return the copyright field from the movie or audio file.
		$info['bitRate'] = $this->mediaFile->getBitRate();			//Return the bit rate of the movie or audio file in bits per second.
		if($this->mediaType == self::VIDEO){
			$info['frameRate'] = $this->mediaFile->getFrameRate();		//Return the frame rate of a movie in fps.
			$info['frameHeight'] = $this->mediaFile->getFrameHeight();	//Return the height of the movie in pixels.
			$info['frameWidth'] = $this->mediaFile->getFrameWidth();		//Return the width of the movie in pixels.
			$info['pixelFormat'] = $this->mediaFile->getPixelFormat();	//Return the pixel format of the movie.
			$info['videoBitRate'] = $this->mediaFile->getVideoBitRate();	//Return the bit rate of the video in bits per second.
			//NOTE: The following methods only works for files with constant bit rate.
			if($this->constantBitRate){
				$info['audioBitRate'] = $this->mediaFile->getAudioBitRate();			//Return the audio bit rate of the media file in bits per second.
				$info['audioSampleRate'] = $this->mediaFile->getAudioSampleRate();	//Return the audio sample rate of the media file in bits per second.
				$info['audioChannels'] = $this->mediaFile->getAudioChannels();		//Return the number of audio channels in this movie as an integer.
				$info['audioCodec'] = $this->mediaFile->getAudioCodec();				//Return the name of the audio codec used to encode this movie as a string.
				$info['videoCodec'] = $this->mediaFile->getVideoCodec();				//Return the name of the video codec used to encode this movie as a string.
				$info['frameNumber'] = $this->mediaFile->getFrameNumber();			//Return the current frame index.
				$info['hasAudio'] = $this->mediaFile->hasAudio();						//Return boolean value indicating whether the movie has an audio stream.
				$info['hasVideo'] = $this->mediaFile->hasVideo();						//Return boolean value indicating whether the movie has an video stream.	
			}
		} elseif($this->mediaType == self::AUDIO){
			$info['genre'] = $this->mediaFile->getGenre();				//Return the genre ID3 field from an mp3 file.
			$info['trackNumber'] = $this->mediaFile->getTrackNumber();	//Return the track ID3 field from an mp3 file.
			$info['year'] = $this->mediaFile->getYear();					//Return the year ID3 field from an mp3 file.
		}
		return $info;
	}
	
	/** 
	 *  Generates a jpg image from a movie frame and saves it in the given location.
	 * 
	 * @param		int			$frameNumber
	 * @param		string		$filePath
	 * @param		int			$quality
	 * @param		int			$width
	 * @param		int			$height
	 * @return		bool
	 * 
	 * @see			http://ffmpeg-php.sourceforge.net/doc/api/ffmpeg_movie.php
	 * @see			http://ffmpeg-php.sourceforge.net/doc/api/ffmpeg_frame.php
	 * @see			http://php.net/manual/es/function.imagecreatetruecolor.php
	 * @see			http://php.net/manual/es/function.imagecopyresampled.php
	 * @see			http://php.net/manual/es/function.imagejpeg.php
	 */
	public function saveFrameImage($frameNumber, $filePath, $quality=100, $width=null, $height=null){
		$frame = $this->mediaFile->getFrame($frameNumber);
		if($frame){
			$frameImage = $frame->toGDImage();
			$gdImage = '';
			if(!empty($width) && !empty($height)){
				$gdImage = imagecreatetruecolor($width, $height);
				imagecopyresampled($gdImage, $frameImage, 0, 0, 0, 0, $width, $height, $frame->getWidth(), $frame->getHeight());
			} else {
				$gdImage = $frameImage;
			}
			$fileName = end(explode('/', $filePath));
			$folderPath = substr($filePath, 0, strrpos($filePath, '/'));
			if(is_dir($folderPath)){
				imagejpeg($gdImage, $filePath, $quality);
				return true;
			} else {
				$this->error = 'Destination folder "'.$folderPath.'" does not exist';
				return false;
			}
		} else {
			$this->error = 'Unable to get frame '.$frameNumber.' from "'.$this->mediaFile->getFilename().'"';
			return false;
		}
	}
	
	/** 
	 *  Returns a frame from the movie as an ffmpeg_frame object. Returns false if the frame was not found.
	 * 
	 * @param		int			$frameNumber
	 * @see			http://ffmpeg-php.sourceforge.net/doc/api/ffmpeg_animated_gif.php
	 */
	public function getAnimatedGif(){
		throw new Exception('Non implemented method. MediaFile->getAnimatedGif()');
	}
}