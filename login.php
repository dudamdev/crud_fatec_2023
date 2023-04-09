<?php

// Função usada para controlar o buffer de saída do PHP. O ob_start() inicia o buffer.
ob_start();

// Inicia a sessão para o usuário que está tentando fazer login.
session_start(); // Inicia a sessão

// Inclui o arquivo de configuração que contém as informações de conexão com o banco de dados.
require_once 'config.php';

// Verifica se o formulário foi submetido pelo método POST.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os valores dos campos de email e senha do formulário.
    $email = $_POST['email_login'];
    $senha = $_POST['senha_login'];

    // Verifica se o email e senha são válidos
    // Monta a query SQL para buscar o usuário com o email e senha informados.
    $query = "SELECT id, nome FROM fatec_admin WHERE email='$email' AND senha=md5('$senha')";

    // Executa a query no banco de dados.
    $result = mysqli_query($conn, $query);

    // Verifica se a query retornou apenas um resultado.
    if (mysqli_num_rows($result) == 1) {
        // Captura os dados do usuário retornado pela query.
        $row = mysqli_fetch_assoc($result);
        // Armazena na sessão do usuário o id e nome do usuário logado.
        $_SESSION['id'] = $row['id'];
        $_SESSION['nome'] = $row['nome'];
        // Redireciona o usuário para a página de dashboard.
        header('Location: dashboard.html'); // Redireciona para a página de dashboard
    } else {
        // Caso o email ou senha sejam inválidos, mostra uma mensagem de erro e redireciona o usuário de volta para a página de login.
        echo '<script>alert("Email ou senha incorretos!")</script>'; 
        header("Location: index.html#paralogin");               
    }
}

// Função usada para controlar o buffer de saída do PHP. O ob_end_flush() envia o conteúdo do buffer para o navegador.
ob_end_flush();

// Finaliza o bloco de código PHP.
?> 


