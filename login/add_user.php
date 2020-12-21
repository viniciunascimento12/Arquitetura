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




$id      =  $_POST['id'];
$nome      =  $_POST['nome'];
$tipo      =  $_POST['tipo'];
$preco      =  $_POST['preco'];
$descricao      =  $_POST['descricao'];




$sql = " SELECT * FROM estoque WHERE id = '$id' ";



$paciente_existe = false;
$nome_existe = false;

$resultado_id = mysqli_query($conexao, $sql);

if ($resultado_id) {
	
	$dados_user = mysqli_fetch_array($resultado_id);

	if (isset($dados_user['id'])){

		$paciente_existe = true;

	}

    } else 	{
	echo 'Error na execução!';
}


$sql = " SELECT * FROM estoque WHERE id = '$id' ";


$resultado_id = mysqli_query($conexao, $sql);

if ($resultado_id) {
	
	$dados_user = mysqli_fetch_array($resultado_id);

	if (isset($dados_user['id'])){

		$nome_existe = true;

	}

    } else 	{
	echo 'Error na execução!';
}

if ($paciente_existe || $nome_existe) {

	$retorno_get = "";

	if ($paciente_existe) {
		$retorno_get.= "erro_produto=1&";
	}
	if ($nome_existe) {
		$retorno_get.= "erro_nome_do_produto=1&";
	}
	
	header("Location: cadastrar_produto.php?".$retorno_get);
	die();
}

$sql = "INSERT INTO estoque(id,nome,tipo,preco,descricao)VALUES
   ('$id','$nome','$tipo','$preco','$descricao')";
if (mysqli_query($conexao, $sql)) {
	header("Location: cadastrar_produto.php?sucesso=1");
	$sql = "INSERT INTO estoquegeral(id,nome,tipo,preco,descricao)VALUES
   	('$id','$nome','$tipo','$preco','$descricao')";
   mysqli_query($conexao, $sql);
}else{
	echo "Error!";
}

?>