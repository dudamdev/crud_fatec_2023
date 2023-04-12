<?php

header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id20492682_fatecbd", "id20492682_fatecbdr", "u136I9[JMI}}[cW2");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM fatec_professores 
 ORDER BY id DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if ($received_data->action == 'insert') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':address' => $received_data->address,
        ':course' => $received_data->course,
        ':salary' => $received_data->salary,
    );

    $query = "
 INSERT INTO fatec_professores 
 (first_name, address, course, salary) 
 VALUES (:first_name, :address, :course, :salary)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Professor Adicionado'
    );

    echo json_encode($output);
}

if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_professores 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['first_name'] = $row['first_name'];
        $data['address'] = $row['address'];
        $data['course'] = $row['course'];
        $data['salary'] = $row['salary'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'update') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':address' => $received_data->address,
        ':course' => $received_data->course,
        ':salary' => $received_data->salary,
        ':id' => $received_data->hiddenId
    );

    $query = "
 UPDATE fatec_professores 
 SET first_name = :first_name, 
 address = :address, 
 course = :course, 
 salary = :salary 
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Professor Atualizado'
    );

    echo json_encode($output);
}

if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_professores 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Professor Deletado'
    );

    echo json_encode($output);
}

?>