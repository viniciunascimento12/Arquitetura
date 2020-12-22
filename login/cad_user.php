<?php
    $erro_nome = isset($_GET['erro_nome']) ? $_GET['erro_nome'] : 0;
 ?>
<?php
  $sucesso = isset($_GET['sucesso']) ? $_GET['sucesso'] : 0;
?>

 <form action="add_user.php" method="post">
        <fieldset>
            <legend>Cadastrar novo usuario</legend>
            <label for="Email">Usuário</label>
            <input type="text" name="usuario" id="txUsuario" maxlength="50" />
            <label for="Email">Senha</label>
            <input type="password" name="senha" id="txSenha" />
            <input type="submit" value="Cadastar" />
        </fieldset>
     </form>

      <li><a href="index.php">Login</a></li>
 <?php
              if ($erro_nome == 1) {
                      echo '<font  color="red">Usuário já cadastrado</font>';
                    }
             ?>

             <?php
              if($sucesso == 1){
              echo '<font  color="green">Cadastro realizado com sucesso!</font>';
              }

            ?>
            </div>

