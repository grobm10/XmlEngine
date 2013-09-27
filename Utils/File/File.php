<?php
/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/File.php
 */

class File{

	/** 
	 * Returns an array with matched file names for a folder. 
	 * This feature doesn't lookup recursively into subfolders
	 * 
	 * @param		string			$folderPath
	 * @param		array|string	$extensions
	 * @return		array|string
	 */
	public static function GetFilesList($folderPath, $extensions=array()){
		$arrayTemp = array();
		try{
			if (is_dir($folderPath)){
				if ($dh = opendir($folderPath)){
					while (($file = readdir($dh)) !== false){
						if((substr($file, 0, 1) != '.')){
							$filePath = $folderPath . $file;
							foreach($extensions as $ext){
								$matchsExtension = substr($file, (-1 * strlen($ext))) == $ext;
								if ($matchsExtension){
									$arrayTemp[$file] = $filePath;
									break;
								}
							}
						}
					}
					closedir($dh);
				}
			}
		} catch(Exception $e){
			throw new Exception('There was a low level fatal error scanning the directory. File::GetFilesList(). ' . $e->getMessage());
		}
		asort($arrayTemp);
		return $arrayTemp;
	}
	
	/**
	 * Returns an array with the file info parsed with the stat() function
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @return	string
	 * @see		http://php.net/manual/en/function.filesize.php
	 */
	public static function GetInfo($filePath){
		if(file_exists($filePath)){
			if(is_readable($filePath)){
				$info = array();
				$slashPosition = strrpos($filePath, '/');
				if(empty($slashPosition)){
					$slashPosition = -1;
				}
				$info['path'] = $filePath;
				$info['is_dir'] = is_dir($filePath);
				$info['extension'] = substr($filePath, strrpos($filePath, '.')+1);
				$info['full_name'] = substr($filePath, ($slashPosition+1));
				$info['name'] = substr($info['full_name'], 0, ((strlen($info['extension'])+1)*-1));
				$info['parent_folder'] = self::GetParentFolderPath($filePath);
				$info['creation_date'] = self::GetCreationDate($info['path']);
				$info['modification_date'] = self::GetModificationDate($info['path']);
				$info['last_access_date'] = self::GetLastAccessDate($info['path']);
				if(!is_dir($filePath)){
					$info['size'] = self::GetSize($info['path']);
					$info['md5'] = self::GetMd5($info['path']);
				}
				return $info;
			} else {
				throw new Exception('Permissions denied for '.$filePath.'. File::GetInfo().');
			}
		} else {
			throw new Exception('File '.$filePath.' does not exist. File::GetInfo().');
		}
	}
	
	/**
	 * Returns the file creation date
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @return	string
	 * @see		http://php.net/manual/en/function.filectime.php
	 */
	public static function GetCreationDate($filePath){
		if(file_exists($filePath)){
			if(is_readable($filePath)){
				return date(Date::MYSQL_DATETIME_FORMAT, filectime($filePath));
			} else {
				throw new Exception('Permissions denied for '.$filePath.'. File::GetCreationDate().');
			}
		} else {
			throw new Exception('File '.$filePath.' does not exist. File::GetCreationDate().');
		}
	}
	
	/**
	 * Returns the file modification date
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @return	string
	 * @see		http://php.net/manual/en/function.filemtime.php
	 */
	public static function GetModificationDate($filePath){
		if(file_exists($filePath)){
			if(is_readable($filePath)){
				return date(Date::MYSQL_DATETIME_FORMAT, filemtime($filePath));
			} else {
				throw new Exception('Permissions denied for '.$filePath.'. File::GetModificationDate().');
			}
		} else {
			throw new Exception('File '.$filePath.' does not exist. File::GetModificationDate().');
		}
	}
	
	/**
	 * Returns the file last access date
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @return	string
	 * @see		http://php.net/manual/en/function.fileatime.php
	 */
	public static function GetLastAccessDate($filePath){
		if(file_exists($filePath)){
			if(is_readable($filePath)){
				return date(Date::MYSQL_DATETIME_FORMAT, fileatime($filePath));
			} else {
				throw new Exception('Permissions denied for '.$filePath.'. File::GetLastAccessDate().');
			}
		} else {
			throw new Exception('File '.$filePath.' does not exist. File::GetLastAccessDate().');
		}
	}
	
	/**
	 * Returns the file size
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @return	string
	 * @see		http://php.net/manual/en/function.filesize.php
	 */
	public static function GetSize($filePath){
		if(file_exists($filePath)){
			if(is_file($filePath)){
				if(is_readable($filePath)){
					return filesize($filePath);
				} else {
					throw new Exception('Permissions denied for '.$filePath.'. File::GetSize().');
				}
			} else {
				throw new Exception($filePath.' is not a file. File::GetSize().');
			}
		} else {
			throw new Exception('File '.$filePath.' does not exist. File::GetSize().');
		}
	}
	
	/**
	 * Calculates the md5 value for the file
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @return	string
	 * @see		http://php.net/manual/en/function.md5-file.php
	 */
	public static function GetMd5($filePath){	
		if(file_exists($filePath)){
			if(is_file($filePath)){
				if(is_readable($filePath)){
					return md5_file($filePath);
				} else {
					throw new Exception('Permissions denied for '.$filePath.'. File::GetMd5().');
				}
			} else {
				throw new Exception($filePath.' is not a file. File::GetMd5().');
			}
		} else {
			throw new Exception('File '.$filePath.' does not exist. File::GetMd5().');
		}
	}
	
	/**
	 * Retrieves the parent folder path from the file path
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @param	bool	$includeSlash
	 * @return	string
	 */
	public static function GetParentFolderPath($filePath, $includeSlash=false){
		$slashPosition = strrpos($filePath, '/');
		if($slashPosition === false){
			return '';
		}
		if($includeSlash){
			++$slashPosition;
		}
		return substr($filePath, 0, $slashPosition);
	}
	
	/**
	 * Retrieves the extension from the file path
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @return	string
	 */
	public static function GetExtensionFromPath($filePath){	
		return substr($filePath, strrpos($filePath, '.')+1);
	}
	
	/**
	 * Retrieves the file name and extension from the file path
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @return	string
	 */
	public static function GetNameFromPath($filePath){	
		$fileName = '';
		$slashPosition = strrpos($filePath, '/');
		if ($slashPosition === false){
			return $filePath;
		} else {
			return substr($filePath, ($slashPosition+1));
		}
	}
	
	/**
	 * Retrieves the name of the file without the extension
	 * 
	 * @static	static
	 * @param	string	$filePath
	 * @return	string
	 */
	public static function GetNameWithoutExtension($filePath){
		$fileName = self::GetNameFromPath($filePath);
		return substr($fileName, 0, ((strlen(self::GetExtensionFromPath($filePath))+1)*-1));
	}
}