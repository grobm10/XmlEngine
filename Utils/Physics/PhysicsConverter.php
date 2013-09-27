<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Physics/PhysicsConverter.php
 */
class PhysicsConverter
{
	/**
	 * Converts a value from the given longitude measurement unit to the requested one.
	 *
	 * @param		float			$value
	 * @param		string			$from
	 * @param		string			$to
	 * @return		float
	 * @static
	 */
	public static function changeLengthUnit($value, $from, $to) {
		//convert the value in $from unit to METERS
		$meters = 0;
		switch($from){
			case PhysicsUnits::MILLIMETERS :
				$meters = floatval($value) / 1000;
				break;
			case PhysicsUnits::CENTIMETERS :
				$meters = floatval($value) / 100;
				break;
			case PhysicsUnits::METERS :
				$meters = floatval($value);
				break;
			case PhysicsUnits::KILOMETERS :
				$meters = floatval($value) * 1000;
				break;
			case PhysicsUnits::GEO_COORDS :
				//1 GEO_COORD ~= 111.12 KM
				$meters = floatval($value) * (111.12 * 1000);
				break;
			default:
				throw new Exception('Unable to recognize Length Measurement Unit.(PhisicsConverter::changeLengthUnit)');
		}
		//convert the value in METERS to the requested measurement unit
		$converted = 0;
		switch($to){
			case PhysicsUnits::MILLIMETERS :
				$converted = $meters * 1000;
				break;
			case PhysicsUnits::CENTIMETERS :
				$converted = $meters * 100;
				break;
			case PhysicsUnits::METERS :
				$converted = $meters;
				break;
			case PhysicsUnits::KILOMETERS :
				$converted = $meters / 1000;
				break;
			case PhysicsUnits::GEO_COORDS :
				// 111120 METERS ~= 1 GEO_COORD
				$converted = $meters / (111.12 * 1000);
				break;
			default:
				throw new Exception('Unable to recognize Length Measurement Unit.(PhisicsConverter::changeLengthUnit)');
		}
		return $converted;
	}
	
	/**
	 * Converts a value from the given time measurement unit to the requested one.
	 *
	 * @param		float			$value
	 * @param		string			$from
	 * @param		string			$to
	 * @return		float
	 * @static
	 */
	public static function changeTimeUnit($value, $from, $to) {
		//convert the value in $from unit to SECONDS
		$seconds = 0;
		switch($from){
			case PhysicsUnits::HOURS :
				$seconds = floatval($value) * 3600;
				break;
			case PhysicsUnits::MINUTES :
				$seconds = floatval($value) * 60;
				break;
			case PhysicsUnits::SECONDS :
				$seconds = floatval($value);
				break;
			default:
				throw new Exception('Unable to recognize Time Measurement Unit.(PhisicsConverter::changeTimeUnit)');
		}
		//convert the value in SECONDS to the requested measurement unit
		$converted = 0;
		switch($to){
			case PhysicsUnits::HOURS :
				$converted = $seconds / 3600;
				break;
			case PhysicsUnits::MINUTES :
				$converted = $seconds / 60;
				break;
			case PhysicsUnits::SECONDS :
				$converted = $seconds;
				break;
			default:
				throw new Exception('Unable to recognize Time Measurement Unit.(PhisicsConverter::changeTimeUnit)');
		}
		return $converted;
	}
	
	/**
	 * Converts a value from the given velocity measurement unit to the requested one.
	 *
	 * @param		float			$value
	 * @param		string			$from
	 * @param		string			$to
	 * @return		float
	 * @static
	 */
	public static function changeVelocityUnit($value, $from, $to) {
		//convert the value in $from unit to METERS_PER_SECOND
		$mtsPerSec = 0;
		switch($from){
			case PhysicsUnits::METERS_PER_SECOND :
				$mtsPerSec = floatval($value);
				break;
			case PhysicsUnits::KM_PER_HOUR :
				$kmPerSec = $value / self::changeTimeUnit(1, PhysicsUnits::HOURS, PhysicsUnits::SECONDS);
				$mtsPerSec = self::changeLengthUnit($kmPerSec, PhysicsUnits::KILOMETERS, PhysicsUnits::METERS);
				break;
			case PhysicsUnits::GEO_COORDS_PER_SECOND :
				$mtsPerSec = self::changeLengthUnit($value, PhysicsUnits::GEO_COORDS, PhysicsUnits::METERS);
				break;
			default:
				throw new Exception('Unable to recognize Velocity Measurement Unit.(PhisicsConverter::changeVelocityUnit)');
		}
		//convert the value in METERS_PER_SECOND to the requested measurement unit
		$converted = 0;
		switch($to){
			case PhysicsUnits::METERS_PER_SECOND :
				$converted = $mtsPerSec;
				break;
			case PhysicsUnits::KM_PER_HOUR :
				$kmPerSec = self::changeLengthUnit($mtsPerSec, PhysicsUnits::METERS, PhysicsUnits::KILOMETERS);
				$converted = $kmPerSec * self::changeTimeUnit(1, PhysicsUnits::HOURS, PhysicsUnits::SECONDS);
				break;
			case PhysicsUnits::GEO_COORDS_PER_SECOND :
				$converted = self::changeLengthUnit($mtsPerSec, PhysicsUnits::METERS, PhysicsUnits::GEO_COORDS);
				break;
			default:
				throw new Exception('Unable to recognize Velocity Measurement Unit.(PhisicsConverter::changeVelocityUnit)');
		}
		return $converted;
	}
}