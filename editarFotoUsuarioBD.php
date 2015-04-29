<?php
require_once("./conf/confBD.php");
include_once("./modelos/cabecalho_login.html");
require_once("./authSession.php");

//Iniciando verificação de upload de imagem
$permissoes = array("gif", "jpeg", "jpg", "png", "image/gif", "image/jpeg", "image/jpg", "image/png");  //strings de tipos e extensoes validas
$temp = explode(".", basename($_FILES["fileName"]["name"]));
$extensao = end($temp);
if ((in_array($extensao, $permissoes))
&& (in_array($_FILES["fileName"]["type"], $permissoes))
&& ($_FILES["fileName"]["size"] < 500000))
  {
  if ($_FILES["fileName"]["error"] > 0)
    {
    echo "<h1>Erro no envio, código: " . $_FILES["fileName"]["error"] . "</h1>";
    }
  else
    {
	  $dirUploads = "fotos/";
	  $nomeUsuario = utf8_encode($_SESSION['login']);	  

	  if(!file_exists ( $dirUploads ))
			mkdir($dirUploads, 0500);  //permissao de leitura e execucao
	  
	  $caminhoUpload = $dirUploads.$nomeUsuario."/";
	  if(!file_exists ( $caminhoUpload ))
			mkdir($caminhoUpload, 0700);  //permissoes de escrita, leitura e execucao
			
	  $pathCompleto = ($caminhoUpload.remover_caracter(basename($_FILES["fileName"]["name"])));


	  
	  if(move_uploaded_file($_FILES["fileName"]["tmp_name"], $pathCompleto))		
	   	   echo "<figure><img class=\"img-thumbnail\" src=\"$pathCompleto\" title=\"Upload do usuário\"></figure>";
      else
		echo "<h1>Problemas ao armazenar o arquivo. Tente novamente.<h1>";
    }
  }
else
  {
  echo "<h1>Arquivo inválido<h1>";
  }
  //Finalizando Upload de imagem
  $login = utf8_encode($_SESSION['login']);

try
{
	// se não foram passados 4 parâmetros na requisição e não vier da página de cadastro
	//desvia para a mensagem de erro: 	// "previne" acesso direto à página
	$origem = basename($_SERVER['HTTP_REFERER']);
	if($origem!='editarFotoPerfil.php'){
		header("Location:./acessoNegado.php");
		die();
	}
	//se existem os parâmetros...
	else{
		//instancia objeto PDO, conectando-se ao mysql
		$conexao = conn_mysql();
	
		$SQLUpdate = 'UPDATE  participantes SET  arquivoFoto =  ? WHERE  login = ?';			  
		//prepara a execução
		$operacao = $conexao->prepare($SQLUpdate);					  
	

		
							  
	   //executa a sentença SQL com os parâmetros passados por um vetor
		$inserir = $operacao->execute(array( $pathCompleto, $login));
		
			
		// fecha a conexão ao banco
		$conexao = null;
		
		//verifica se o retorno da execução foi verdadeiro ou falso,
		//imprimindo mensagens ao cliente
		if ($inserir){
			 echo "<h1>Alteração efetuado com sucesso.</h1>\n";
			 echo "<p class=\"lead\"><a href=\"./principal.php\">Página principal</a></p>\n";
		}
		else {
			echo "<h1>Erro na operação.</h1>\n";
				$arr = $operacao->errorInfo();		//mensagem de erro retornada pelo SGBD
				$erro = utf8_decode($arr[2]);
				echo "<p>$erro</p>";							//deve ser melhor tratado em um caso real
			    echo "<p><a href=\"./cadastroUsuario.php\">Retornar</a></p>\n";
		}
    }
}
catch (PDOException $e)
{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

function remover_caracter($string) {
    $string = preg_replace("/[áàâãä]/", "a", $string);
    $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
    $string = preg_replace("/[éèê]/", "e", $string);
    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
    $string = preg_replace("/[íì]/", "i", $string);
    $string = preg_replace("/[ÍÌ]/", "I", $string);
    $string = preg_replace("/[óòôõö]/", "o", $string);
    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
    $string = preg_replace("/[úùü]/", "u", $string);
    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
    $string = preg_replace("/ç/", "c", $string);
    $string = preg_replace("/Ç/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
    $string = preg_replace("/ /", "_", $string);
    return $string;
}
include_once("./modelos/rodape_login.html");

?>
