<?php
// processa_cadastro.php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha

    // Verificar se o email já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "Email já cadastrado. <a href='cadastrar.php'>Tente novamente</a>.";
        exit;
    }

    // Inserir novo usuário
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha);
    
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso. <a href='login.php'>Faça login</a>.";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>


<!-- 
    1) Como é feita a verificação se um email já está cadastrado no sistema?
    2) Qual função é usada para proteger a senha do usuário antes de ser armazenada no banco de dados?
    3) O que acontece se ocorrer um erro ao inserir um novo usuário no banco de dados?
    4) Qual método é utilizado para proteger contra ataques de SQL Injection ao inserir um novo usuário?
 
    resposta:

    1)A verificação se um e-mail já está cadastrado é feita com uma consulta ao banco de dados para checar se o e-mail fornecido já existe na tabela de usuários. Se encontrado, o sistema informa que o e-mail está em uso.

    2)A função usada para proteger a senha do usuário antes de armazená-la no banco de dados é password_hash(). Ela gera um hash seguro da senha, que é armazenado no banco de dados em vez da senha em texto claro.

    3) Se ocorrer um erro ao inserir um novo usuário no banco de dados, o sistema geralmente exibe uma mensagem de erro para o usuário e pode registrar o erro em um log para análise posterior. A inserção falha e o usuário não é adicionado ao banco de dados.

    4) Para proteger contra ataques de SQL Injection ao inserir um novo usuário, utiliza-se prepared statements com bind parameters. Isso garante que os dados sejam tratados como valores, não como parte da consulta SQL.
-->