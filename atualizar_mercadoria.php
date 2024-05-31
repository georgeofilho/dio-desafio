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
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $usuario_id = 1; // Assumindo que o ID do usuário logado é 1

    $stmt = $conn->prepare("CALL atualizar_mercadoria(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdii", $id, $nome, $descricao, $preco, $quantidade, $usuario_id);

    if ($stmt->execute()) {
        echo "Mercadoria atualizada com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Atualização de Mercadorias</title>
</head>
<body>
    <h2>Atualização de Mercadorias</h2>
    <form method="post">
        ID: <input type="number" name="id" required><br>
        Nome: <input type="text" name="nome" required><br>
        Descrição: <textarea name="descricao" required></textarea><br>
        Preço: <input type="text" name="preco" required><br>
        Quantidade em Estoque: <input type="number" name="quantidade" required><br>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
