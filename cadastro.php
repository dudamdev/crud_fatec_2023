<?php

// Define o cabeçalho CORS para permitir que qualquer origem acesse o recurso.
header('Access-Control-Allow-Origin: *');

// Cria uma nova conexão PDO com o banco de dados MySQL.
$connect = new PDO("mysql:host=localhost;dbname=id20492682_fatecbd", "id20492682_fatecbdr", "u136I9[JMI}}[cW2");

// Decodifica o conteúdo da requisição AJAX, que deve estar no formato JSON, em um objeto PHP.
$received_data = json_decode(file_get_contents("php://input"));

// Cria um array vazio que será preenchido com dados do banco de dados e usado para gerar a resposta JSON.
$data = array();

// Se a ação solicitada pela requisição AJAX for 'fetchall', o script executa uma consulta SQL para buscar todos os registros da tabela fatec_alunos, adiciona cada registro ao array $data e retorna a resposta JSON com todos os registros.
if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM fatec_alunos 
 ORDER BY id DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

// Se a ação solicitada pela requisição AJAX for 'insert', o script insere um novo registro na tabela fatec_alunos com o primeiro nome e o último nome recebidos pela requisição e retorna a resposta JSON com a mensagem 'Aluno Adicionado'.
if ($received_data->action == 'insert') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':last_name' => $received_data->lastName
    );

    $query = "
 INSERT INTO fatec_alunos 
 (first_name, last_name) 
 VALUES (:first_name, :last_name)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Aluno Adicionado'
    );

    echo json_encode($output);
}

// Se a ação solicitada pela requisição AJAX for 'fetchSingle', o script executa uma consulta SQL para buscar o registro com o ID especificado pela requisição, adiciona os dados do registro ao array $data e retorna a resposta JSON com os dados do registro.
if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_alunos 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['first_name'] = $row['first_name'];
        $data['last_name'] = $row['last_name'];
    }

    echo json_encode($data);
}

// Se a ação solicitada pela requisição AJAX for 'update', o script atualiza o registro com o ID especificado pela requisição com o primeiro nome e o último nome recebidos pela requisição e retorna a resposta JSON com a mensagem 'Aluno Atualizado'.
if ($received_data->action == 'update') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':last_name' => $received_data->lastName,
        ':id' => $received_data->hiddenId
    );

    $query = "
 UPDATE fatec_alunos 
 SET first_name = :first_name, 
 last_name = :last_name 
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Aluno Atualizado'
    );

    echo json_encode($output);
}

//  Se a ação solicitada pela requisição AJAX for 'delete', o script exclui o registro com o ID especificado pela requisição e retorna a resposta JSON com a mensagem 'Aluno Deletado'.
if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_alunos 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Aluno Deletado'
    );

    echo json_encode($output);
}

?>