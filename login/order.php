<?php 
  session_start(); 
  if(isset($_SESSION['nome_user_sessao'])){
  ?>

     <?php
      $servidor = "localhost"; /*maquina a qual o banco de dados está*/
      $usuario = "root"; /*usuario do banco de dados MySql*/
      $senha = ""; /*senha do banco de dados MySql*/
      $banco = "loja"; /*seleciona o banco a ser usado*/

      $conexao = mysqli_connect($servidor,$usuario,$senha,$banco) or die("Erro ao conectar ao servidor:".mysqli_error());  /*Conecta no bando de dados MySql*/

      

      mysqli_query($conexao, "SET NAMES 'utf8'");
      mysqli_query($conexao, "SET character_set_connection=uf8");
      mysqli_query($conexao, "SET character_set_client=uf8");
      mysqli_query($conexao, "SET character_set_results=uf8");

     $res = mysqli_query($conexao, "SELECT * FROM estoquegeral ORDER BY id ASC"); /*Executa o comando SQL, no caso para pegar todos os usuarios do sistema e retorna o valor da consulta em uma variavel ($res)  */

      echo "<div id ='' class='nav navbar-right panel_toolbox'></div>
                      <table class='table table-responsive'>
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nome do Produto</th>
                          <th>Tipo de Produto</th>
                          <th>Preco do Produto</th>
                          <th>Descrição do Produto</th>
                        </tr>
                      </thead>
                     ";

      /*Enquanto houver dados na tabela para serem mostrados será executado tudo que esta dentro do while */
       $cont = 0;
      while($escrever = mysqli_fetch_array($res)){


        $verif = $escrever['id'];

          /*Escreve cada linha da tabela*/

                echo "<tbody>
                        <tr>

                          <td>" . $escrever['id'] . "</td>
                          <td>" . $escrever['nome'] . "</td>
                          <td>" . $escrever['tipo'] . "</td>
                          <td>" . $escrever['preco'] . "</td>
                          <td>" . $escrever['descricao'] . "</td>
                          <td><form method=\"post\" action=deletar.php id=\"formCadastrarse\">
            <div class=\"form-group\" align=\"center\">
                  <div class=\"col-md-6 col-sm-6 col-xs-12 col-md-offset-3\">
                     <button type=\"submit\" name=\"test\" value=\"".$verif."\" class=\"bbtn btn-danger\">Deletar</button>
                 </div>
                 </div>
                 </form>
                  </div>
                </div>
              </form>
            </div> </td>

                        </tr>
                      </tbody>
            ";


            $cont++;
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