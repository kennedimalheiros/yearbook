<?php
require_once("./conf/confBD.php");
include_once("./modelos/cabecalho_login.html");
?>

    <div class="container">

      <div>
        
        
		 <form role="form" method="post" action="./cadastroNovoUsuario.php" class="form-signin" enctype="multipart/form-data">
		 <h3 class="form-signin-heading">Yearbook<br> Cadastro de Usuário</h3>
			  <div class="form-group">
				<label for="InputNome">Nome Completo:</label>
				<input type="text" class="form-control" id="InputNome" name="nomeCompleto" placeholder="Nome completo" required autofocus>
			  </div>
			  <div class="form-group">
			  <label for="InputLogin">Login:</label>
				<input type="text" class="form-control" id="InputLogin" name="nomeUsuario" placeholder="Login desejado" required>
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
				<input type="text" class="form-control" id="InputEmail" name="email" placeholder="Email" required >
			  </div>
              <div class="form-group">
				<label for="InputDescricao">Descrição:</label>
				<input type="text" class="form-control" id="InputDescricao" name="descricao" placeholder="Descrição" required >
			  </div>
              <div class="form-group">     
                <label for="fileName">Escolha um arquivo: </label>
			    <input type="file" name="fileName" id="fileName" placeholder="Escolha um arquivo" required>
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

				
			  <button type="submit" class="btn btn-primary">Cadastrar</button>
		 </form>

	 </div>

	  
	  
    </div><!-- /.container -->

<?php
include_once("./modelos/rodape_bdcompleto.html");
?>