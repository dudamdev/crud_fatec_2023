<!-- Código PHP cria uma conexão com um banco de dados MySQL utilizando a biblioteca mysqli. -->
<?php

// As variáveis $host, $user, $pass e $dbname armazenam respectivamente o nome do servidor MySQL, o usuário do MySQL, a senha do MySQL e o nome do banco de dados que se deseja conectar.
$host = "localhost"; // nome do servidor MySQL
$user = "id20492682_fatecbdr"; // usuário do MySQL
$pass = "u136I9[JMI}}[cW2"; // senha do MySQL
$dbname = "id20492682_fatecbd"; // nome do banco de dados

// Conexão com o banco de dados MySQL
// A função mysqli_connect() é utilizada para estabelecer uma conexão com o banco de dados e recebe como parâmetros as informações de acesso (host, usuário, senha e nome do banco de dados). Essa função retorna um objeto de conexão mysqli ou FALSE caso ocorra algum erro.
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Verifica se houve erro na conexão
// A condição if (!$conn) é utilizada para verificar se a conexão foi estabelecida com sucesso. Caso a conexão não tenha sido estabelecida, o script é encerrado com a função die() que exibe a mensagem "Falha na conexão: " seguida do erro retornado pela função mysqli_connect_error().
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
