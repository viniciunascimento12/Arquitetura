
<?php  
			// host
			 $host = 'localhost';
			//usuario
			 $user = 'root';
			//senha
			 $password = '';
			// banco de dados
			 $database = 'loja';
			$conexao = mysqli_connect($host, $user, $password, $database) or die("Erro ao conectar ao servidor:".mysqli_error());
		

			mysqli_query($conexao, "SET NAMES 'utf8'");
			mysqli_query($conexao, "SET character_set_connection=uf8");
			mysqli_query($conexao, "SET character_set_client=uf8");
			mysqli_query($conexao, "SET character_set_results=uf8");

			function protege($string){
			// host
			 $host = 'localhost';
			//usuario
			 $user = 'root';
			//senha
			 $password = '';
			// banco de dados
			 $database = 'loja';
			$conexao = mysqli_connect($host, $user, $password, $database) or die("Erro ao conectar ao servidor:".mysqli_error());
		

			mysqli_query($conexao, "SET NAMES 'utf8'");
			mysqli_query($conexao, "SET character_set_connection=uf8");
			mysqli_query($conexao, "SET character_set_client=uf8");
			mysqli_query($conexao, "SET character_set_results=uf8");

			$string = stripcslashes($string);
			$string = strip_tags($string);
			$string = mysqli_real_escape_string($conexao,$string); 

			return $string;
			}

			$usuario    =  protege($_POST['usuario']);
			$senha      =  protege($_POST['senha']);

			$resultado_id = mysqli_query($conexao, " SELECT * FROM usuarios WHERE nome = '$usuario' AND senha = '$senha' ");
			$linhas = mysqli_num_rows($resultado_id);

		    if ($linhas == '') {
					header("Location: index.php?erro=1");
				}
			else{
				while ($dados = mysqli_fetch_assoc($resultado_id)) {
					session_start();
					$_SESSION['nome_user_sessao'] = $dados['nome'];
					header ("Location: inicio.php");
				}
			}

?>