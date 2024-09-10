<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redirecionar para login se não estiver logado
    exit();
}

$user_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY data_pedido DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2>Meus Pedidos</h2>
    <?php if ($result->num_rows > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID do Pedido</th>
                    <th>Data do Pedido</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['data_pedido']); ?></td>
                        <td>R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Você ainda não fez nenhum pedido.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<!-- 
    1) Qual é a finalidade do arquivo meus_pedidos.php?

    2) O que acontece se um usuário tentar acessar meus_pedidos.php sem estar logado?

    3) Como os pedidos são ordenados na página meus_pedidos.php?

    4) O que é exibido na página se o usuário não tiver feito nenhum pedido?

    resposta:

    1) O arquivo meus_pedidos.php exibe os pedidos feitos pelo usuário, geralmente mostrando um histórico de compras, detalhes dos pedidos e status atual.

    2) Se um usuário tentar acessar meus_pedidos.php sem estar logado, ele geralmente é redirecionado para a página de login ou recebe uma mensagem informando que o acesso é restrito a usuários autenticados.

    3) Na página meus_pedidos.php, os pedidos são geralmente ordenados por data, status ou número do pedido, conforme especificado na consulta ao banco de dados. A ordenação é configurada usando cláusulas SQL como ORDER BY.

    4) Se o usuário não tiver feito nenhum pedido, a página meus_pedidos.php geralmente exibe uma mensagem informando que nenhum pedido foi encontrado ou que o usuário ainda não fez compras.
-->