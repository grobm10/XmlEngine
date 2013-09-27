<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Data/Date.php
 */
class Date {

	const MYSQL_DATE_FORMAT = 'Y-m-d';
	const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';
	const MYSQL_TIME_FORMAT = 'H:i:s';
	
	const SECONDS_PER_HOUR = 3600;
	const SECONDS_PER_DAY = 86400;
	const SECONDS_PER_WEEK = 604800;
	
	const GREATER_THAN = 'GT';
	const LOWER_THAN = 'LT';
	const EQUAL = 'EQ';
	const NOT_EQUAL = 'NEQ';
	const GREATER_THAN_OR_EQUAL = 'GTOE';
	const LOWER_THAN_OR_EQUAL = 'LTOE';
	const SAME_DAY = 'SD';
	const DIFFERENT_DAY = 'DD';
	
	/** 
	 * Retrieves the current date with the GMT format
	 * 
	 * @return		string
	 * @static
	 */
	public static function Get(){
		return date(Date::MYSQL_DATETIME_FORMAT);
	}
	
	/** 
	 * Tries to parse the given date to create a MySQL datetime value
	 * 
	 * @param		string			$date
	 * @return		string
	 * @static
	 */
	public static function ParseDate($date=null){
		if(!empty($date)){
			if (($timestamp = strtotime($date)) !== false) {
				return date(Date::MYSQL_DATETIME_FORMAT, $timestamp);
			} else {
				return false;
			}
		} else {
			return self::Get();
		}
	}
	
	/** 
	 * Retrieves the numbers of seconds in the given string time
	 * 
	 * @param		string		$time
	 * @return		int
	 * @example		Date::GetNumberOfSeconds('05:23:56');
	 * @static
	 */
	public static function GetNumberOfSeconds($time){
		$seconds = 0;
		$timeArray = explode(':', $time);
		if(count($timeArray) == 3){
			$seconds = intval($timeArray[2]);
			$seconds += intval($timeArray[1])*60;
			$seconds += intval($timeArray[0])*3600;
		}
		return $seconds;
	}
	
	/**
	 * Retrieves the numbers of seconds between two dates
	 *
	 * @param		string		$from
	 * @param		string		$to
	 * @return		int
	 * @example		Date::GetElapsedSeconds('2012-11-07 14:59:34', '2012-11-10 14:59:34');
	 * @static
	 */
	public static function GetElapsedSeconds($from, $to){
		if (($from = strtotime($from)) !== false) {
			if (($to = strtotime($to)) !== false) {
				if ($from < $to) {
					return $to - $from;
				} else {
					return $from - $to;
				}
			}
		}
		return false;
	}
	
	/**
	 * Compares two dates with different opperators
	 *
	 * @param		string		$date1
	 * @param		string		$to
	 * @param		string		$date2
	 * @return		int
	 * @example		Date::Is('2012-11-07 14:59:34', '2012-11-10 14:59:34');
	 * @static
	 */
	public static function Is($date1, $opperator, $date2){
		$result = null;
		if (($timestamp1 = strtotime($date1)) !== false) {
			if (($timestamp2 = strtotime($date2)) !== false) {
				switch($opperator){
					case Date::GREATER_THAN:
						$result = $timestamp1 > $timestamp2;
						break;
					case Date::LOWER_THAN:
						$result = $timestamp1 < $timestamp2;
						break;
					case Date::EQUAL:
						$result = $timestamp1 == $timestamp2;
						break;
					case Date::NOT_EQUAL:
						$result = $timestamp1 != $timestamp2;
						break;
					case Date::GREATER_THAN_OR_EQUAL:
						$result = $timestamp1 >= $timestamp2;
						break;
					case Date::LOWER_THAN_OR_EQUAL:
						$result = $timestamp1 <= $timestamp2;
						break;
					case Date::LOWER_THAN_OR_EQUAL:
						$result = $timestamp1 > $timestamp2;
						break;
					case Date::SAME_DAY:
						$result = substr($date1, 0, 6) == substr($date2, 0, 6);
						break;
					case Date::DIFFERENT_DAY:
						$result = substr($date1, 0, 6) != substr($date2, 0, 6);
						break;
				}
				return $result;
			}
		}
		return false;
	}
}
