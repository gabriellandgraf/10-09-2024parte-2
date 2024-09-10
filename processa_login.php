<?php
session_start();
include 'db_connect.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consultar o usuário no banco de dados
    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id, $user_name, $hashed_password);
        $stmt->fetch();

        // Verificar a senha
        if (password_verify($senha, $hashed_password)) {
            // Definir as variáveis de sessão
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['user_name'] = $user_name;
            
            // Redirecionar para a página inicial ou onde o usuário estava
            header('Location: index.php');
            exit();
        } else {
            // Senha incorreta
            echo "Senha incorreta.";
        }
    } else {
        // Usuário não encontrado
        echo "Usuário não encontrado.";
    }
}
?>


<!-- 
    1) Como o sistema verifica se as credenciais de login estão corretas?

    2) O que acontece quando o usuário é autenticado com sucesso?

    3) Como o sistema lida com uma tentativa de login com senha incorreta?

    4) Qual comando é usado para iniciar uma sessão no script processa_login.php?

    resposta:

    1) O sistema verifica se as credenciais de login estão corretas comparando a senha fornecida com o hash armazenado no banco de dados, usando funções como password_verify(). Se a senha for válida, o usuário é autenticado e autorizado a acessar a aplicação.

    2) Quando o usuário é autenticado com sucesso, o sistema inicia uma sessão para o usuário e geralmente redireciona-o para uma página específica, como a página inicial ou o painel do usuário.

    3) O sistema lida com uma tentativa de login com senha incorreta exibindo uma mensagem de erro e, geralmente, mantendo o usuário na página de login para tentar novamente.

    4) O comando usado para iniciar uma sessão no script processa_login.php é session_start().
-->