<?php

	function dumpx($arg) { dump($arg); exit; }
	function dump($args) { $print = print_r($args, 1); $print = str_replace(array('<', '>'), array('&lt;', '&gt;'), $print); echo "<pre>$print</pre>"; }

	// Subida del archivo
	$dir_subida = __DIR__ . '/files/';
	$fichero_subido = $dir_subida . basename($_FILES['fileToUpload']['name']);

	if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $fichero_subido)) {
		echo "Error: el archivo no se guardó.";
		exit;
	} 

	//Clases
	include 'class/cubo.php';

	// Variables
	$file = new SplFileObject($fichero_subido);
	$filas = array();
	$nm = array();

	// Recorro el archivo para extraer la información.
	while (!$file->eof()) {
		// Se crea un array para guardar cada linea del archivo.
		$filas[] = explode(" ", $file->fgets());
	}

	$file = null;
	
	$i = -1;
	foreach ($filas as $fila) {
		// Las lineas que tengan sólo 2 columnas, son los bloques de operaciones.
		if	(count($fila) == 2){
			$i++;
			$nm[$i][0] = $fila[0];
			$nm[$i][1] = $fila[1];
		} else if (count($fila) != 1){
			// Se guardan las operaciones, relacionadas con el bloque.
			$nm[$i][2][] = $fila;
		}
	}

	// Validaciones y Ejecución.
	if	($filas[0][0] == count($nm)){
		
		// Validación 1 <= T <= 50  
		if	(!$filas[0][0] >= 1 && !$filas[0][0] <= 50){
			echo "Error: El número de Casos de prueba, debe ser mayor que 1 y menor que 50";
			exit;
		}
		
		$b = 0;
		foreach ($nm as $bloque){
			echo "Bloque: " . $b . "<br>";
			
			// Validación 1 <= N <= 100 
			$n = $bloque[0];
			if	(!$n >= 1 && !$n <= 100) {
				echo "Error: El tamaño del cubo (N), debe ser mayor que 1 y menor que 100";
				exit;
			}
			
			// Validación 1 <= M <= 1000 
			$m = $bloque[1];
			if	(!$m >= 1 && !$m <= 1000) {
				echo "Error: El número de operaciones, debe ser mayor que 1 y menor que 1000";
				exit;
			}
			
			$matr = new cubo($n, $m);
			if	($bloque[1] == count($bloque[2])){
				foreach ($bloque[2] as $operacion) {
					
					if	(strtolower($operacion[0]) == "update"){
						$x = $operacion[1];
						$y = $operacion[2];
						$z = $operacion[3];
						$val = $operacion[4];
						
						// Validación 1 <= x,y,z <= N 
						if	 (!($x >= 1 && $x <= $n) || !($y >= 1 && $y <= $n) || !($z >= 1 && $z <= $n)){
							echo "Error: Los números del operador update, para buscar el bloque, deben ser mayor que 1 y menor que " . $n;
							exit;
						}
						
						// Validación -10^9 <= W <= 10^9
						if	(!$x >= -1000000000 && !$x <= 1000000000){
							echo "Error: El valor a actualizar debe ser mayor que -1.000.000.000 y menor que 1.000.000.000";
							exit;
						}
						
						$matr->update($x, $y, $z, $val);
					} else if (strtolower($operacion[0]) == "query") {
						$x1 = $operacion[1];
						$y1 = $operacion[2];
						$z1 = $operacion[3];
						$x2 = $operacion[4];
						$y2 = $operacion[5];
						$z2 = $operacion[6];
						
						// Validación 1 <= x1 <= x2 <= N, 1 <= y1 <= y2 <= N, 1 <= z1 <= z2 <= N 
						if	(!$x1 >= 1 && !$x1 <= $n || !$x2 >= 1 && !$x2 <= $n || !$y1 >= 1 && !$y1 <= $n || !$y2 >= 1 && !$y2 <= $n || !$z1 >= 1 && !$z1 <= $n || !$z2 >= 1 && !$z2 <= $n){
							echo "Error: Los números del query deben ser mayor que 1 y menor que " . $n;
							exit;
						}
						
						echo $matr->query($x1, $y1, $z1, $x2, $y2, $z2) . "<br>";
					} else {
						echo "Error, operador no encontrado";
					}
					
				}
			} else {
				echo "El número de operaciones no coinciden, en este bloque deben ser: " . $bloque[1] . " Operaciones";
			}
			$b++;
		}
	} else {
		echo "Los casos de pruebas ingresados no son " . $filas[0][0];
	}
	

?>
