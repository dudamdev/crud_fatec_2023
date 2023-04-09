<?php

// Função que inicia um buffer de saída para armazenar o conteúdo HTML que será gerado pelo script PHP.
ob_start();

// Função que inicia a sessão PHP para o usuário, permitindo o armazenamento de variáveis que serão utilizadas em outras páginas do site.
session_start(); // Inicia a sessão

// Importa o arquivo "config.php", que contém as configurações do banco de dados. 
require_once 'config.php';

// Condição que verifica se o formulário foi enviado pelo método POST, ou seja, se o usuário preencheu os campos de cadastro e clicou em "Enviar".
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebem os valores preenchidos pelo usuário nos campos de cadastro e os armazenam em variáveis PHP para uso posterior.
    $nome = $_POST['nome_cad'];
    $email = $_POST['email_cad'];
    $senha = $_POST['senha_cad'];

    // Verifica se o email já está em uso
    // Realiza uma consulta SQL no banco de dados para verificar se o email informado já está em uso por outro usuário.
    $query = "SELECT * FROM fatec_admin WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    // Verifica se a consulta SQL retornou algum resultado, indicando que o email já está em uso por outro usuário.
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Este email já está em uso!');</script>";
    } else {
        // Insere o novo usuário no banco de dados
        // Realiza uma inserção SQL no banco de dados para cadastrar o novo usuário com nome, email e senha informados pelo usuário. A função md5() é utilizada para criptografar a senha antes de armazená-la no banco.
        $query = "INSERT INTO fatec_admin (nome, email, senha) VALUES ('$nome', '$email', md5('$senha'))";

        // Verifica se a inserção SQL foi bem sucedida, ou seja, se o novo usuário foi cadastrado com sucesso no banco de dados.
        if (mysqli_query($conn, $query)) {
            // Exibe uma mensagem de sucesso em um alerta JavaScript para o usuário, indicando que o cadastro foi concluído com sucesso.
            echo '<script>alert("Usuário cadastrado com sucesso!")</script>';
            // Redireciona o usuário para a página inicial do site com a âncora "#paralogin", que indica que o formulário de login deve ser exibido.
            header("Location: index.html#paralogin");
        // Condição executada caso a inserção SQL não tenha sido bem sucedida, exibindo uma mensagem de erro ao usuário e redirecionando-o para a página de cadastro.
        } else {
            echo '<script>alert("Erro ao cadastrar usuário!")</script>';
            header("Location: index.html#paracadastro");
        }
    }
}

// Função que finaliza o buffer
ob_end_flush();

/*
CREATE TABLE fatec_admin (
id INT(11) NOT NULL AUTO_INCREMENT,
nome VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
senha VARCHAR(100) NOT NULL,
PRIMARY KEY (id),
UNIQUE KEY email (email)
);
*/


?>