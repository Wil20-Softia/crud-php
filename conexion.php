<?php
	
	try{

		$base= new PDO ('mysql:host=localhost; dbname=crud', "root", "wilsonweenoo2012");

		$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$base->exec("SET CHARACTER SET UTF8");

	}catch(Exeption $e){

		die("ERROR: " . $e->getMessage());

		echo "Linea del Error: " . $e->getLine();
		
	}

?>