<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Data/Date.php
 */
class Arrays{
	/**
	 * Replaces the array1 properties with the array2 non empty properties
	 *
	 * @param		array|mixed		$array1
	 * @param		array|mixed		$array2
	 * @return 		array|mixed
	 */
	public static function RecursiveMerge($array1, $array2){
		$merged = $array1;
		foreach($array2 as $key => $value){
			if(isset($array1[$key])){
				if(is_array($value)){
					if(count($value) > 0){
						$merged[$key] = self::RecursiveMerge($array1[$key], $array2[$key]);
					}
				} elseif($value !== null && trim($value) !== null) {
					$merged[$key] = $value;
				}
			} else {
				$merged[$key] = $value;
			}
		}
		return $merged;
	}
}