<head>
<meta http-equiv="refresh" content="5;url=./logout.php">
</head>
<?php

require_once("./authSession.php");
require_once("./conf/confBD.php");
include_once("./modelos/cabecalho_login.html");
try
{
	// se não foram passados 4 parâmetros na requisição e não vier da página de cadastro
	//desvia para a mensagem de erro: 	// "previne" acesso direto à página
	//$origem = basename($_SERVER['HTTP_REFERER']);

	if (utf8_encode($_SESSION['login']) != ($_GET['nomeUsuario'])){
	///	if($origem!='editarPerfil.php'){
	header("Location:./acessoNegado.php");
	die();
	}
	//se existem os parâmetros...
	else{
		//instancia objeto PDO, conectando-se ao mysql
		$conexao = conn_mysql();
		
		//captura valores do vetor POST
		//utf8_encode para manter consistência da codificação utf8 nas páginas e no banco
		$login = utf8_encode(htmlspecialchars($_GET['nomeUsuario']));
		
		

		// cria instrução SQL parametrizada
		$SQLUpdate = 'DELETE FROM participantes WHERE login = ?';

					  
		//prepara a execução
		$operacao = $conexao->prepare($SQLUpdate);					  
	

		 //executa a sentença SQL com os parâmetros passados por um vetor
		 $inserir = $operacao->execute(array( $login));

			
		// fecha a conexão ao banco
		$conexao = null;
		
		//verifica se o retorno da execução foi verdadeiro ou falso,
		//imprimindo mensagens ao cliente
		if ($inserir){
			echo "<h1>Exclusão efetuado com sucesso.</h1>\n";
			echo "<p class=\"lead\"><a href=\"./logout.php\">Página principal</a></p>\n";
//			header("Location:./logout.php");
		}
		else {
			echo "<h1>Erro na operação.</h1>\n";
				$arr = $operacao->errorInfo();		//mensagem de erro retornada pelo SGBD
				$erro = utf8_decode($arr[2]);
				echo "<p>$erro</p>";							//deve ser melhor tratado em um caso real
			    echo "<p><a href=\"./exccluirUsuarioBD.php\">Retornar</a></p>\n";
		}
    }
}
catch (PDOException $e)
{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

include_once("./modelos/rodape_login.html");

?>
