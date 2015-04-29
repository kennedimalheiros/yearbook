<?php
session_start();
	
    require_once("./conf/confBD.php"); 
	
      if(isset($_POST["login"])){		//existe um login enviado via POST (formulário)
            $log = utf8_encode(htmlspecialchars($_POST["login"]));
            $senha = utf8_encode(htmlspecialchars($_POST["passwd"]));
			if(isset($_POST["lembrarLogin"]))
				$lembrar = utf8_encode(htmlspecialchars($_POST["lembrarLogin"]));
			else 
			    $lembrar="";
         
      }
      elseif(isset($_COOKIE["loginAutomatico"])){ 	//existe um cookie com nome senha --> login automático
            $log = utf8_encode(htmlspecialchars($_COOKIE["loginAgenda"]));
            $senha = utf8_encode(htmlspecialchars($_COOKIE["loginAutomatico"]));
		   }
        else{
	  	       header("Location:./erroLogin.php");
               die();
		}         
 try{
		// instancia objeto PDO, conectando no mysql
		$conexao = conn_mysql();
						
		// instrução SQL básica (sem restrição de nome)
		$SQLSelect = 'SELECT * FROM participantes WHERE senha=MD5(?) AND login=?';
				
		//prepara a execução da sentença
		$operacao = $conexao->prepare($SQLSelect);					  
				
		//executa a sentença SQL com o valor passado por parâmetro
		$pesquisar = $operacao->execute(array($senha, $log));
		
		//captura TODOS os resultados obtidos
		$resultados = $operacao->fetchAll();
		
		// fecha a conexão (os resultados já estão capturados)
		$conexao = null;
		
		
		// se há zero ou mais de um resultado, login inválido.
		if (count($resultados)!=1){	
			header("Location:./erroLogin.php");
            die();
		}   
		else{ // se há um resultado, login confirmado.
			setcookie("loginAgenda", $log, time()+60*60*24*90); //guarda o login por 90 dias a partir de agora
			if(!empty($lembrar)){
 			    setcookie("loginAutomatico", $senha, time()+60*60*24*90); //guarda a senha por 90 dias a partir de agora	
			}
		   $_SESSION['auth']=true;
		   $_SESSION['nomeCompleto'] = $resultados[0]['nomeCompleto'];
		   $_SESSION['urlFoto'] = $resultados[0]['arquivoFoto'];
		   $_SESSION['descricao'] = $resultados[0]['descricao'];
		   $_SESSION['login'] = $log;
		   header("Location: ./principal.php");
		   die();
		}
	} //try
	catch (PDOException $e)
	{
		// caso ocorra uma exceção, exibe na tela
		echo "Erro!: " . $e->getMessage() . "<br>";
		die();
	}
?>