<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Data/Number.php
 */
class Number
{
	/** 
	 * Convert the given number to a float value with specific decimal positions
	 * 
	 * @param		mixed		$number
	 * @param		int			$decimalPositions
	 * @return		float
	 * @static
	 */
	public static function getDecimalValue($number, $decimalPositions){
		return floatval(number_format($number, $decimalPositions, '.', ''));
	}
}