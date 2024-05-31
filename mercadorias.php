<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $usuario_id = 1; // Assumindo que o ID do usuário logado é 1

    $stmt = $conn->prepare("CALL inserir_mercadoria(?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdii", $nome, $descricao, $preco, $quantidade, $usuario_id);

    if ($stmt->execute()) {
        echo "Mercadoria inserida com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Mercadorias</title>
</head>
<body>
    <h2>Cadastro de Mercadorias</h2>
    <form method="post">
        Nome: <input type="text" name="nome" required><br>
        Descrição: <textarea name="descricao" required></textarea><br>
        Preço: <input type="text" name="preco" required><br>
        Quantidade em Estoque: <input type="number" name="quantidade" required><br>
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
