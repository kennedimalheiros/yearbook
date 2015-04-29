<?php
require_once("./authSession.php");
require_once("./conf/confBD.php");
include_once("./modelos/cabecalho_bdcompleto.html");
?>
</br></br>
    <div class="container">

      <div class="starter-template">
        <h3 class="sub-header">Welcome to Year Book - <?PHP echo utf8_decode($_SESSION['nomeCompleto']);?></h3>    
      </div>
	  
<?php
try{
	// instancia objeto PDO, conectando no mysql
	$conexao = conn_mysql();
		
		$nomeUser = utf8_encode($_SESSION['login']);
				
		// instrução SQL básica (sem restrição de nome)
		$SQLSelect = 'SELECT * FROM participantes';
	
	   if(!empty($_POST['filtro'])){
	         $nomeBusca = utf8_encode(htmlspecialchars($_POST['filtro']));
			 $nomeBusca = "%".$nomeBusca."%";
			 $SQLSelect .= ' AND nomeCompleto like ?';
		}
			
		//prepara a execução da sentença
		$operacao = $conexao->prepare($SQLSelect);					  
		if(!empty($_POST['filtro'])){				
			//executa a sentença SQL com o valor passado por parâmetro
			$pesquisar = $operacao->execute(array($nomeUser, $nomeBusca));
		}
		else
			$pesquisar = $operacao->execute(array($nomeUser));
		//captura TODOS os resultados obtidos
		$resultados = $operacao->fetchAll();
		
		// fecha a conexão (os resultados já estão capturados)
		$conexao = null;
		
		//INICIO PERFIL DO USUARIO
		echo "<div  class=\"col-lg-3 col-md-3 col-xs-4 thumb\">";
		echo 	"<figure>";
		echo 		"<a class=\"thumbnail\" href=\"perfil.php?filtro=".utf8_encode($_SESSION['login'])."\">";
		echo			"<img class=\"img-responsive\" src=\"".utf8_encode($_SESSION['urlFoto'])."\" >";          
		echo		"</a>";
		echo 	"</figure>";
		echo    "<h5>".utf8_decode($_SESSION['nomeCompleto'])."</h5>";
		echo    "<h5>".utf8_decode($_SESSION['descricao'])."</h5>";
		echo "</div>";
		//FIM PERFIL DO USUARIO
		
		// se há resultados, os escreve em uma tabela
		if (count($resultados)>0){
			echo "<div class=\"row\">";
			
				foreach($resultados as $participantesEncontrados){		//para cada elemento do vetor de resultados...
					
					//Removendo o ususario do Perfil de Participantes
					if (utf8_decode($participantesEncontrados['login'])  != utf8_decode($_SESSION['login']) ){
					
						echo "<div class=\"col-lg-1 col-md-2 col-xs-3 thumb\">";
						echo 	"<figure>";
						echo 		"<a class=\"thumbnail\" href=\"perfil.php?filtro=".utf8_decode($participantesEncontrados['login'])."\">";
						echo			"<img class=\"img-responsive\" src=\"".utf8_decode($participantesEncontrados['arquivoFoto'])."\" >";          
						echo		"</a>";
						echo 	"</figure>";
						echo    "<h5>".utf8_decode($participantesEncontrados['nomeCompleto'])."</h5>";
						echo "</div>";
					}
				}
										
			echo "</div>"; //Row	
		}
		else{
			echo'<div class="starter-template">';
			echo"\n<h3 class=\sub-header\>Nenhum participante encontrado.</h3>";
			echo'</div>';
		}
	
	} //try
	catch (PDOException $e)
	{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
	}
	
?>	
	  
    </div><!-- /.container -->

<?php
include_once("./modelos/rodape_bdcompleto.html");
?>