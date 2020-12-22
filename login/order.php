<?php 
  session_start(); 
  if(isset($_SESSION['nome_user_sessao'])){
  ?>

   <?php  echo $_SESSION['nome_user_sessao'];

     "Estou logado:"
    ?>
    <li><a href="inicio.php">inicio</a></li>

     <?php
      $servidor = "localhost"; /*maquina a qual o banco de dados está*/
      $usuario = "root"; /*usuario do banco de dados MySql*/
      $senha = "root"; /*senha do banco de dados MySql*/
      $banco = "go"; /*seleciona o banco a ser usado*/

      $conexao = mysqli_connect($servidor,$usuario,$senha,$banco) or die("Erro ao conectar ao servidor:".mysqli_error());  /*Conecta no bando de dados MySql*/

      

      mysqli_query($conexao, "SET NAMES 'utf8'");
      mysqli_query($conexao, "SET character_set_connection=uf8");
      mysqli_query($conexao, "SET character_set_client=uf8");
      mysqli_query($conexao, "SET character_set_results=uf8");
     $user = $_SESSION['nome_user_sessao'];
     $res = mysqli_query($conexao, "SELECT * FROM pagamento WHERE email = '$user'"); /*Executa o comando SQL, no caso para pegar todos os usuarios do sistema e retorna o valor da consulta em uma variavel ($res)  */

      echo "
                    <table class='table table-responsive'>
                      <thead>
                        <tr>
                          <th>Nome</th>
                          <th>Status</th>
                          <th>ID do produto</th>
                          <th>Telefone</th>
                          <th>Data de criação</th>
                        </tr>
                      </thead>
                     ";

      /*Enquanto houver dados na tabela para serem mostrados será executado tudo que esta dentro do while */
      while($escrever = mysqli_fetch_array($res)){
          /*Escreve cada linha da tabela*/

                echo "<tbody>
                        <tr>
                          <td>" . $escrever['nome'] . "</td>
                          <td>" . $escrever['status'] . "</td>
                          <td>" . $escrever['produto'] . "</td>
                          <td>" . $escrever['fone'] . "</td>
                          <td>" . $escrever['createdAt'] . "</td>
                        </tr>
                      </tbody>
            ";
        } /*Fim do while*/
        echo " </table>"; /*fecha a tabela apos termino de impressão das linhas*/     
       ?>
<?php
  }
  else{

    $retorno_get = "";
    $retorno_get.= "erroSessao=1";
    header("Location: index.php?".$retorno_get);
}
?>