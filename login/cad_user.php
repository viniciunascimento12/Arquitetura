<?php 
  session_start(); 
  if(isset($_SESSION['nome_user_sessao'])){
  ?>
<?php
    $erro_produto = isset($_GET['erro_produto']) ? $_GET['erro_produto'] : 0;
 ?>
 <?php
    $erro_nome_do_produto = isset($_GET['erro_nome_do_produto']) ? $_GET['erro_nome_do_produto'] : 0;
 ?>
<?php
  $sucesso = isset($_GET['sucesso']) ? $_GET['sucesso'] : 0;
?>

 <form action="verificacao.php" method="post">
        <fieldset>
            <legend>Dados de Login</legend>
            <label for="Email">Usuário</label>
            <input type="text" name="usuario" id="txUsuario" maxlength="25" />
            <label for="Email">Senha</label>
            <input type="password" name="senha" id="txSenha" />
            <input type="submit" value="Cadastar" />
        </fieldset>
     </form>
<?php
  }
  else{
    $retorno_get = "";
    $retorno_get.= "erroSessao=1";
    header("Location: index.php?".$retorno_get);
}
?>