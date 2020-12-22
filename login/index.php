<?php
  $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
?>
<?php
  $logout = isset($_GET['logout']) ? $_GET['logout'] : 0;
?>
<?php
  $erroSessao = isset($_GET['erroSessao']) ? $_GET['erroSessao'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head> Inserir dadas login </head>
<body>
 <!-- Formulário de Login -->
    <form action="verificacao.php" method="post">
        <fieldset>
            <legend>Dados de Login</legend>
            <label for="txUsuario">Usuário</label>
            <input type="text" name="usuario" id="txUsuario" maxlength="50" />
            <label for="txSenha">Senha</label>
            <input type="password" name="senha" id="txSenha" />
            <input type="submit" value="Entrar" />
        </fieldset>
     </form>
      <li><a href="cad_user.php">cadastr-se</a></li>
               <?php
                  if($erroSessao == 1){
                     echo '<font color="#FF0000">Efetue seu Login!</font>';
                    }
                  ?>
                 <?php
                  if($erro == 1){
                    echo '<font color="#FF0000">Usuário ou Senha incorreto(s)</font>';
                  }
                ?>
                <?php
                  if($logout == 1){
                    echo '<font color="blue">Logout efetuado com sucesso!</font>';
                  }
                ?>
</body>
</html>