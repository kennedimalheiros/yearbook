<?php
 function conn_mysql(){

   	$servidor = 'us-cdbr-azure-west-b.cleardb.com';
   
	$porta = 3306;
   
	$banco = "as_c8ada907de505d8";
   
	$usuario = "b7750a8ba0d583";
   
	$senha = "0b53e433";
   
	try{
     
		$conn = new PDO("mysql:host=$servidor;
						   
		port=$porta;
						   
		dbname=$banco", 
						   
		$usuario, 
						   
		$senha,
						   
		array(PDO::ATTR_PERSISTENT => true));
		  
		return $conn;
    }
    catch(PDOException $e){
		echo "<br> Ocorreu um erro ao conectar o banco de dados, contate o susporte. <br> Email: kennedimalheiros@gmail.com<br> ";
        //echo $e;
    }

   }

?>