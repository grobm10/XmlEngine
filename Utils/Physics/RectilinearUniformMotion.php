<?php/**  * @author			David Curras * @version			June 6, 2012 * @filesource		/Utils/Physics/RectilinearUniformMotion.php */class RectilinearUniformMotion{	/**	 * Calculates the velocity for the given displacement and time.	 * Does not handle measurement units.	 *	 * @param		float		$displacement	 * @param		float		$time	 * @return		float	 * @static	 */	public static function getVelocity($displacement, $time) {		$velocity = abs(floatval($displacement) / floatval($time));		return $velocity;	}		/**	 * Calculates the displacement for the given velocity and time.	 * Does not handle measurement units.	 *	 * @param		float		$velocity	 * @param		float		$time	 * @return		float	 * @static	 */	public static function getDisplacement($velocity, $time) {		$displacement = abs(floatval($velocity) * floatval($time));		return $displacement;	}		/**	 * Calculates the time for the given velocity and displacement.	 * Does not handle measurement units.	 *	 * @param		float		$velocity	 * @param		float		$displacement	 * @return		float	 * @static	 */	public static function getTime($velocity, $displacement) {		$time = abs(floatval($displacement) / floatval($velocity));		return $time;	}	/**	 * Moves an agent from the original point in the plane with the given velocity	 * and elapsed time over a straight line to the destination point.	 * Does not handle measurement units. 	 *	 * @param		GeometricPoint		$originalPoint	 * @param		GeometricPoint		$destinationPoint	 * @param		float				$velocity	 * @param		float				$elapsedTime	 * @return		float	 * @static	 */	public static function moveAgentInThePlane($originalPoint, $destinationPoint, $velocity, $elapsedTime) {		$angle = Geometry::getAngle($originalPoint, $destinationPoint);		$distance = self::getDisplacement($velocity, $elapsedTime);		return Geometry::movePoint($originalPoint, $angle, $distance);	}}