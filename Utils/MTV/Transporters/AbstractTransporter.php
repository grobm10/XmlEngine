<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/Transporters/AbstractTransporter.php
 */
abstract class AbstractTransporter {
	/**
	 * Uploads the current asset to the partner server
	 * 
	 * @param	Bundle	$bundle
	 * @param	bool	$isRemote
	 * @return 	bool
	 * @static
	 */
	public static function Upload($bundle, $isRemote=false){
		throw new Exception('Non implemented method AbstractTransporter::Upload');
	}
	
	/**
	 * Parses the upload application output to know if the process success or fails.
	 * 
	 * @param	string	$folderName
	 * @return 	bool
	 * @static
	 */
	protected static function ParseClientOutput($outputLines){
		throw new Exception('Non implemented method AbstractTransporter::ParseClientOutput');
	}
}