<?php
require_once("./conf/confBD.php");
include_once("./modelos/cabecalho_login.html");
try
{
	// se não foram passados 4 parâmetros na requisição e não vier da página de cadastro
	//desvia para a mensagem de erro: 	// "previne" acesso direto à página
	$origem = basename($_SERVER['HTTP_REFERER']);
	if($origem!='editarPerfil.php'){
		header("Location:./acessoNegado.php");
		die();
	}
	//se existem os parâmetros...
	else{
		//instancia objeto PDO, conectando-se ao mysql
		$conexao = conn_mysql();
		
		//captura valores do vetor POST
		//utf8_encode para manter consistência da codificação utf8 nas páginas e no banco
		$nome = utf8_encode(htmlspecialchars($_POST['nomeCompleto']));
		$login = utf8_encode(htmlspecialchars($_POST['nomeUsuario']));
        $email = utf8_encode(htmlspecialchars($_POST['email']));        
        $descricao = utf8_encode(htmlspecialchars($_POST['descricao']));
        $cidade = utf8_encode(htmlspecialchars($_POST['cidade']));		
		
		if ($_POST['passwd']!=''){
		  $senha = utf8_encode(htmlspecialchars($_POST['passwd']));
		  $senhaConf = utf8_encode(htmlspecialchars($_POST['passwd2']));
		  if(($senha!=$senhaConf)||(strlen($senha)<4)||(strlen($senha)>8)){
		    header("Location:./erroCadastro.php");
		    die();
		  }
		}
		

		if ($_POST['passwd']!=''){
		// cria instrução SQL parametrizada
		$SQLUpdate = 'UPDATE  participantes SET  senha =  MD5(?), nomeCompleto =  ?,  cidade =  ?, email = ?,
							  descricao = ? WHERE  login = ?';
					  
					 				  
		}else{
		// cria instrução SQL parametrizada
		$SQLUpdate = 'UPDATE  participantes SET  nomeCompleto =  ?, cidade =  ?, email = ?,
							  descricao = ? WHERE  login = ?';
		}
					  
		//prepara a execução
		$operacao = $conexao->prepare($SQLUpdate);					  
	
		if ($_POST['passwd']!=''){
		  //executa a sentença SQL com os parâmetros passados por um vetor
		  $inserir = $operacao->execute(array($senha, $nome, $cidade,$email,$descricao, $login));
		}else{
		  //executa a sentença SQL com os parâmetros passados por um vetor
		  $inserir = $operacao->execute(array( $nome, $cidade,$email,$descricao, $login));
		}
			
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
			    echo "<p><a href=\"./editarPerfil.php\">Retornar</a></p>\n";
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
