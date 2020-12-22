<?php
  session_start();
  if(isset($_SESSION['nome_user_sessao'])){
  ?>

  <?php  echo $_SESSION['nome_user_sessao'];

   "Estou logado:"
  ?>
  <li><a href="order.php">Minhas Ordens</a></li>
 <li><a href="logout.php">sair</a></li>

<?php
  }
  else{
    $retorno_get = "";
    $retorno_get.= "erroSessao=1";
    header("Location: index.php?".$retorno_get);
}
?>