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
		$SQLSelect = 'SELECT * FROM participantes inner join cidades on participantes.cidade = cidades.idCIdade  where login = "'.$nomeUser.'"';
		
		
		//prepara a execução da sentença
		$operacao = $conexao->prepare($SQLSelect);					  

		$pesquisar = $operacao->execute();
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
		
			
		foreach($resultados as $participantesEncontrados){		//para cada elemento do vetor de resultados...
				

		echo "<div class=\"col-lg-5 col-md-5 col-xs-5 \">";			


					?>	
									
				
	
	
	 <form role="form" method="post" action="./editarUsuarioBD.php" class="form-signin" enctype="multipart/form-data">

		  <div class="form-group">
			<label for="InputNome">Nome Completo:</label>
			<?php
			echo "<input type=\"text\" class=\"form-control\" id=\"InputNome\" name=\"nomeCompleto\" placeholder=\"Nome completo\" value=\"".utf8_decode($participantesEncontrados['nomeCompleto'])."\" required autofocus>"
			?>
		  </div>
		  <div class="form-group">
		  <label for="InputLogin">Login:</label>
			<?php
			echo "<input type=\"text\" class=\"form-control\" id=\"InputLogin\" name=\"nomeUsuario\" placeholder=\"Login desejado\" value=\"".utf8_decode($participantesEncontrados['login'])."\" readonly>"
			?>
		  </div>
		  <div class="form-group">
			<label for="InputSenha">Senha:</label>
			<input type="password" class="form-control" id="InputSenha" name="passwd" placeholder="Senha (4 a 8 caracteres)">
		  </div>
		  <div class="form-group">
			<label for="InputSenhaConf">Confirmação de Senha:</label>
			<input type="password" class="form-control" id="InputSenhaConf" name="passwd2" placeholder="Confirme a senha">
		  </div>
		  <div class="form-group">
			<label for="InputEmail">Email:</label>
			<?php
			echo "<input type=\"text\" class=\"form-control\" id=\"InputEmail\" name=\"email\" placeholder=\"Email\" value=\"".utf8_decode($participantesEncontrados['email'])."\" required autofocus>"
			?>
		  </div>
		  <div class="form-group">
			<label for="InputDescricao">Descrição:</label>
			<?php
			echo "<input type=\"text\" class=\"form-control\" id=\"InputDescricao\" name=\"descricao\" placeholder=\"Descrição\" value=\"".utf8_decode($participantesEncontrados['descricao'])."\" required autofocus>"
			?>
		  </div>

			
		<div class="form-group">
				<select name="estado" size="1" required >
			  
			  <?php
					// instancia objeto PDO, conectando no mysql
					$conexao = conn_mysql();
					
					// instrução SQL básica (sem restrição de nome)
					$SQLSelect = 'select * from estados';
					//prepara a execução da sentença
					$operacao = $conexao->prepare($SQLSelect);
					//executa a sentença SQL com o valor passado por parâmetro
					$pesquisar = $operacao->execute();	
					//captura TODOS os resultados obtidos
					$resultados = $operacao->fetchAll();
					// fecha a conexão (os resultados já estão capturados)
					$conexao = null;
				if (count($resultados)>0){
					foreach($resultados as $participantesEncontrados){		//para cada resultados...
						echo "<option value='".($participantesEncontrados['idEstado'])."'>".($participantesEncontrados['sigaEstado'])."</option>";						
					}
				}

			   ?>
			</select>
		</div>	
		<!-- VOU IMPLEMENTAR DEPOIS A SELEÇÃO DE ESTADOS PARA CARREGAR CIDADE POIS NÃO TIVE TEMPO -->
		<div class="form-group">
				<select name="cidade" size="1" required >
			  
			  <?php
					// instancia objeto PDO, conectando no mysql
					$conexao = conn_mysql();
					
					// instrução SQL básica (sem restrição de nome)
					$SQLSelect = 'select * from cidades';
					//prepara a execução da sentença
					$operacao = $conexao->prepare($SQLSelect);
					//executa a sentença SQL com o valor passado por parâmetro
					$pesquisar = $operacao->execute();	
					//captura TODOS os resultados obtidos
					$resultados = $operacao->fetchAll();
					// fecha a conexão (os resultados já estão capturados)
					$conexao = null;
				if (count($resultados)>0){
					foreach($resultados as $participantesEncontrados){		//para cada resultados...
						echo "<option value='".($participantesEncontrados['idCidade'])."'>".($participantesEncontrados['nomeCidade'])."</option>";						
					}
				}

			   ?>
			</select>
		</div>

			
		  <button type="submit" class="btn btn-primary">Atualizar</button>
	 </form>

					
					
						
		
					
<?php		
	}
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