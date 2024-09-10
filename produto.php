<?php
// Inclua o arquivo de conexão com o banco de dados
include 'db_connect.php';

// Consultar produto específico se o ID for passado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM produtos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Produto não encontrado.";
        exit();
    }
} else {
    echo "ID do produto não especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Loja Virtual</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cadastrar.php">Cadastrar</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="nav-item">
                    <span class="navbar-text">Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-user"></i> Sair
                    </a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cadastrar.php">Cadastro</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <img src="uploads/<?php echo htmlspecialchars($row['imagem']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['nome']); ?>">
            </div>
            <div class="col-md-6">
                <h2><?php echo htmlspecialchars($row['nome']); ?></h2>
                <p><?php echo htmlspecialchars($row['descricao']); ?></p>
                <h3>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></h3>
                <a href="adicionar_carrinho.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-success">Adicionar ao Carrinho</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>



<!-- 
    1) Qual é a finalidade do arquivo produto.php?

    2) Como a imagem do produto é exibida na página?

    3) Qual é a função do botão "Adicionar ao Carrinho" na página do produto?

    4) O que acontece se o ID do produto fornecido não for encontrado no banco de dados?

    resposta:

    1) O arquivo produto.php exibe detalhes de um produto específico, como descrição, preço, imagens e opções de compra, com base na identificação do produto fornecida na URL ou consulta.

    2) A imagem do produto é exibida na página `produto.php` usando uma tag `<img>` no HTML, com o URL da imagem recuperado do banco de dados e inserido como o atributo `src`.

    3) O botão "Adicionar ao Carrinho" na página do produto adiciona o item selecionado ao carrinho de compras do usuário, permitindo que ele prossiga para o checkout ou continue comprando.

    4) Se o ID do produto fornecido não for encontrado no banco de dados, a página geralmente exibe uma mensagem de erro ou uma página de produto não encontrado, informando que o produto não está disponível.
-->