<?php
setcookie("loginAgenda", '', time()-42000); 
setcookie("loginAutomatico", '', time()-42000); 

include_once("./modelos/cabecalho_login.html");

?>

    <div class="container">

      <div>
        <h1>Não foi possível realizar o login.</h1>
		<p class="lead"><a href="./index.php">Tente novamente.</a></p>
        
	 </div>

	  
	  
    </div><!-- /.container -->

<?php
include_once("./modelos/rodape_login.html");
?>