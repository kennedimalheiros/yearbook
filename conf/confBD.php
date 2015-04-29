<?php
 function conn_mysql(){

   	$servidor = 'localhost';
   
	$porta = 3306;
   
	$banco = "pucminas";
   
	$usuario = "pucminas";
   
	$senha = "PucAtividade5";
   
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