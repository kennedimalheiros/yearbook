<?php
require_once("./authSession.php");
require_once("./conf/confBD.php");
include_once("./modelos/cabecalho_bdcompleto.html");
?>
	
	<div class="container">

      <div>
<?php
echo "<br><br><br><br>";
try
{

	// se não foi passado 1 parâmetro via POST, desvia para a mensagem de erro
	// "previne" acesso direto à página	
	if(count($_POST)!=1){
		include("./erroPesquisa.php");
		die();
	}
	else{
	    // instancia objeto PDO, conectando no mysql
		$conexao = conn_mysql();
		
		//captura valores do vetor POST
		//utf8_encode para manter consistência da codificação utf8 nas páginas e no banco
		$nomeBusca = utf8_encode(htmlspecialchars($_POST['criterioPesquisa']));
				
		// instrução SQL básica (sem restrição de nome)
		$SQLSelect = 'SELECT * FROM participantes ';

		//se existe um nome para busca... 
		if(strlen($nomeBusca)>0){
		    $nomeBusca = '%'.$nomeBusca.'%';		
			$SQLSelect = $SQLSelect.'WHERE 	nomeCompleto like ?';	//anexa a restrição à sentença SQL
		}
		
		//prepara a execução da sentença
		$operacao = $conexao->prepare($SQLSelect);					  
				
		//executa a sentença SQL com o valor passado por parâmetro
		$pesquisar = $operacao->execute(array($nomeBusca));
		
		//captura TODOS os resultados obtidos
		$resultados = $operacao->fetchAll();
		
		// fecha a conexão (os resultados já estão capturados)
		$conexao = null;
		
		// se há resultados, os escreve em uma tabela
		if (count($resultados)>0){		
			echo '<table class="table table-striped">';	
			echo '<thead><tr><th colspan="4">Participantes encontrados</th></tr></thead>';
			echo '<thead><tr><th>Nome</th><th>e-mail</th><th>Descrição</th><th>URL Foto</th></tr></thead>';
			echo '<tbody>';
			foreach($resultados as $participantesEncontrados){		//para cada elemento do vetor de resultados...
			
				//em cada 'linha' do vetor de resultados existem elementos com os mesmos nomes dos campos recuperados do SGBD
				echo "\n<tr><td>".utf8_decode($participantesEncontrados['nomeCompleto'])."</td>";
				echo "<td>".utf8_decode($participantesEncontrados['email'])."</td>";
				echo "<td>".utf8_decode($participantesEncontrados['descricao'])."</td>";	
				echo "<td> <figure>"."<img src=\"".utf8_decode($participantesEncontrados['arquivoFoto'])."\" height=120 height=120 ></figure>"."</td></tr>";	

				  
               
					
			}
			echo '</table>';
		}
		else{
			echo"\n<h1>Não foram encontrados participantes com os dados fornecidos</h1>";
		}
		
		echo "\n<p class=\"lead\"><a href=\"./principal.php\">Realizar nova busca</a></p>\n";
		echo"\n<hr>";	
	   die();  
    }
}
catch (PDOException $e)
{
    // caso ocorra uma exceção, a exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}
include_once("./modelos/rodape_bdcompleto.html");
?>
