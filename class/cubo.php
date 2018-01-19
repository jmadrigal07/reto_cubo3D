<?php

	error_reporting(E_ERROR | E_PARSE);
	ini_set('memory_limit', '-1');

	class cubo { 

		private $matrix = array( array(), array(), array() );
		private $n, $m, $opNumber;

		function __construct($n, $m) {
			//Dimenciones de la matriz
			$this->n = $n;
			//Cantidad de operaciones
			$this->m = $m;
			
			$this->llenar_matriz($this->n);
		}

		function llenar_matriz ($size) {
		  for ($i = 0; $i <= $size-1; $i++){
			for( $j = 0; $j <= $size-1; $j++ ){
			  for( $k = 0; $k<= $size-1; $k++ ){
				$this->matrix[$i][$j][$k] = 0;
			  }
			}
		  }
		}
		
		function update ($x, $y, $z, $val) {
			$this->matrix[$x-1][$y-1][$z-1] = $val;
			$this->opNumber++;
		}
		
		function query ($x1, $y1, $z1, $x2, $y2, $z2) {
			$temp = 0;
			
			for ($i = $x1-1; $i <= $x2-1; $i++){
				for( $j = $y1-1; $j <= $y2-1; $j++ ){
				  for( $k = $z1-1; $k <= $z2-1; $k++ ){
					$temp = $temp + $this->matrix[$i][$j][$k];
				  }
				}
			}
			
			$this->opNumber++;
			return $temp;
		}
		
		function getMatrix(){
			return $this->matrix;
		}
		
		function __destruct (){}

	} 

?>