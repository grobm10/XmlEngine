<?php/** * @author			David Curras * @version			June 6, 2012 * @filesource		/Utils/Code/GeometricPoint.php */class GeometricPoint{	protected $x = 0;	protected $y = 0;		/**	 * This object represents a geometric point in the plane	 * @param		int		$x	 * @param		int		$y	 */	public function __construct($x=0, $y=0){		$this->x = floatval($x);		$this->y = floatval($y);	}		/**	 * @return		int	 */	public function getX(){		return $this->x;	}		/**	 * @return		int	 */	public function getY(){		return $this->y;	}}