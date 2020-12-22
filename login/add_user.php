<?php 
	
			// host
			 $host = 'localhost';
			//usuario
			 $user = 'root';
			//senha
			 $password = 'root';
			// banco de dados
			 $database = 'go';

			$conexao = mysqli_connect($host, $user, $password, $database) or die("Erro ao conectar ao servidor:".mysqli_error());
		

			mysqli_query($conexao, "SET NAMES 'utf8'");
			mysqli_query($conexao, "SET character_set_connection=uf8");
			mysqli_query($conexao, "SET character_set_client=uf8");
			mysqli_query($conexao, "SET character_set_results=uf8");




$user      =  $_POST['usuario'];
$pass      =  $_POST['senha'];

$sql = " SELECT * FROM user WHERE user = '$user' ";

$user_existe = false;

$resultado_id = mysqli_query($conexao, $sql);

if ($resultado_id) {
	
	$dados_user = mysqli_fetch_array($resultado_id);

	if (isset($dados_user['user'])){

		$user_existe = true;

	}

    } else 	{
	echo 'Error na execução!';
}


if ($user_existe) {

	$retorno_get = "";

	if ($user_existe) {
		$retorno_get.= "erro_nome=1&";
	}

	header("Location: cad_user.php?".$retorno_get);
	die();
}

$sql = "INSERT INTO user(user,pass)VALUES
   ('$user','$pass')";
if (mysqli_query($conexao, $sql)) {
	header("Location: cad_user.php?sucesso=1");
}else{
	echo "Error!";
}

?>