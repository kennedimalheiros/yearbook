<?php
require_once("./conf/confBD.php");
if(isset($_COOKIE['loginAutomatico'])){
   header("Location: ./VerificarLogin.php");
}
else if(isset($_COOKIE['loginAgenda']))
	$nomeUser = $_COOKIE['loginAgenda'];
	else $nomeUser="";
	
include_once("./modelos/cabecalho_login.html");

?>
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS for the 'Thumbnail Gallery' Template -->
    <link href="dist/css/thumbnail-gallery.css" rel="stylesheet">
    
	<div class="container">
			<div  align="center">
				<figure>
				<img class="img-responsive" src="./img/logo_puc.png"  >         
			   </figure>
             <label>Yearbooks  um projeto interdisciplinar do curso de Pós Graduação de Desenvolvimento de Aplicações Web, o objetivo  é mostra um álbum dos alunos.
			</label>
			</div>


      <div class="starter-template">
        <form class="form-horizontal" role="form" method="post" action="./verificarLogin.php">
        <h3 class="form-signin-heading">Yearbook - Login</h3>
        <input type="text" class="form-control" placeholder="Login" name="login" value="<?php echo $nomeUser?>"required autofocus>
        <input type="password" class="form-control" placeholder="Senha" name="passwd" required>
        <label>
          <input type="checkbox"  name="lembrarLogin" value="loginAutomatico"> Permanecer conectado
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
		<br>
		<button class="btn btn-lg btn-success btn-block" type="button" onclick="javascript:window.location.href='./cadastroUsuario.php'">Cadastrar-se</button>
      </form>
      </div>


<!-- INICIO DO THUMB-->
<?php
try{
	// instancia objeto PDO, conectando no mysql
	$conexao = conn_mysql();		
				
		// instrução SQL básica (sem restrição de nome)
		$SQLSelect = 'SELECT * FROM participantes limit 10';

			
		//prepara a execução da sentença
		$operacao = $conexao->prepare($SQLSelect);					  
		$pesquisar = $operacao->execute(array($nomeUser));
		//captura TODOS os resultados obtidos
		$resultados = $operacao->fetchAll();
		
		// fecha a conexão (os resultados já estão capturados)
		$conexao = null;
		
		// se há resultados, os escreve em uma tabela
		if (count($resultados)>0){
			echo "<div class=\"row\">";

				foreach($resultados as $participantesEncontrados){		//para cada elemento do vetor de resultados...
					
				echo "<div class=\"col-lg-1 col-md-1 col-xs-2 thumbnail\">";
				echo 	"<figure>";
				echo        "<a class=\"thumbnail\" href=\"perfil.php?filtro=".utf8_decode($participantesEncontrados['login'])."\">";
				echo			"<img class=\"img-responsive\" src=\"".htmlspecialchars($participantesEncontrados['arquivoFoto'])."\" >";          
				echo		"</a>";
				echo 	"</figure>";
				echo    "<h5>".utf8_decode($participantesEncontrados['nomeCompleto'])."</h5>";
				echo "</div>";
			   }
		echo "</div>"; //Row
		}
		else{
			echo'<div class="starter-template">';
			echo"\n<h3 class=\sub-header\>Nenhum contato encontrado.</h3>";
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
<!-- FIM  DO THUMB-->	

	</div><!-- /.container -->

    <!-- /.container -->
    <!-- JavaScript -->
    <script src="dist/js/jquery-1.10.2.js"></script>
    <script src="dist/js/bootstrap.js"></script>
	<script src="dist/js/holder.js"></script>
	

<?php
include_once("./modelos/rodape_login.html");
?>