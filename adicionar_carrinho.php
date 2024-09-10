<?php
session_start();
include 'admin/db_connect.php';

// Verificar se o ID do produto foi passado corretamente
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);
$quantidade = 1; // Ajuste conforme necessário

// Consultar o produto pelo ID
$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $produto = $result->fetch_assoc();
    
    // Adicionar produto ao carrinho na sessão
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantidade'] += $quantidade;
    } else {
        $_SESSION['cart'][$id] = array(
            'nome' => $produto['nome'],
            'preco' => $produto['preco'],
            'quantidade' => $quantidade
        );
    }
    
    // Atualizar contagem do carrinho
    $cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantidade')) : 0;
    $_SESSION['cart_count'] = $cart_count;

    // Redirecionar para o carrinho
    header('Location: cart.php');
    exit();
} else {
    // Produto não encontrado
    echo "Produto não encontrado.";
    exit();
}


/* 
1) Como o script adicionar_carrinho.php lida com o ID do produto?

2) O que acontece se o produto não for encontrado no banco de dados durante a adição ao carrinho?

3) Como o script gerencia a quantidade de itens de um mesmo produto no carrinho?

4) Qual é o efeito do comando header('Location: cart.php') no script?

respostas:

1) O script adicionar_carrinho.php lida com o ID do produto recebendo-o via $_POST ou $_GET, verifica se o ID é válido e, se o produto existir, adiciona-o ao carrinho de compras. Se o ID for inválido ou o produto não for encontrado, o script geralmente exibe uma mensagem de erro.

2) Se o produto não for encontrado no banco de dados durante a adição ao carrinho, o script geralmente exibe uma mensagem de erro informando que o produto não está disponível e não o adiciona ao carrinho.

3) O script gerencia a quantidade de itens de um mesmo produto no carrinho atualizando a quantidade existente se o produto já estiver no carrinho, ou adicionando uma nova entrada com a quantidade especificada se não estiver.

4) O comando header('Location: cart.php') redireciona o usuário para a página cart.php, geralmente após a conclusão de uma ação, como adicionar um produto ao carrinho.
*/ 