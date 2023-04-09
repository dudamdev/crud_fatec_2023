<?php

# A linha header('Access-Control-Allow-Origin: *'); é usada para permitir que outras origens façam solicitações a este script. Isso é útil para permitir que o código seja acessado por outras páginas da web.
header('Access-Control-Allow-Origin: *');

# Na linha $connect = new PDO(...);, uma nova conexão PDO é criada para se conectar ao banco de dados MySQL. Os detalhes de conexão (nome do host, nome do banco de dados, nome do usuário e senha) são especificados na linha.
$connect = new PDO("mysql:host=localhost;dbname=id20492682_fatecbd", "id20492682_fatecbdr", "u136I9[JMI}}[cW2");

# Na linha $received_data = json_decode(...);, os dados recebidos por este script são decodificados do formato JSON e armazenados na variável $received_data.
$received_data = json_decode(file_get_contents("php://input"));

# A linha $data = array(); cria uma matriz vazia que será usada para armazenar os dados recuperados do banco de dados.
$data = array();

if($received_data->query != '')
{
	$query = "
	SELECT * FROM fatec_alunos 
	WHERE first_name LIKE '%".$received_data->query."%' 
	OR last_name LIKE '%".$received_data->query."%' 
	ORDER BY id DESC
	";
}
else
{
	$query = "
	SELECT * FROM fatec_alunos 
	ORDER BY id DESC
	";
}

# A linha $statement = $connect->prepare($query);, prepara consulta SQL usando a conexão PDO.
$statement = $connect->prepare($query);

# A linha $statement->execute();, executa a consulta. 
$statement->execute();

# O loop while é usado para iterar sobre os resultados da consulta, e cada linha é adicionada à matriz $data.
while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

# A linha echo json_encode($data);, codifica a matriz $data no formato JSON e envia de volta para a página que solicitou os dados.
echo json_encode($data);

?>