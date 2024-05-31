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
    $usuario_id = 1; // Assumindo que o ID do usuário logado é 1

    $stmt = $conn->prepare("CALL excluir_mercadoria(?, ?)");
    $stmt->bind_param("ii", $id, $usuario_id);

    if ($stmt->execute()) {
        echo "Mercadoria excluída com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exclusão de Mercadorias</title>
</head>
<body>
    <h2>Exclusão de Mercadorias</h2>
    <form method="post">
        ID: <input type="number" name="id" required><br>
        <input type="submit" value="Excluir">
    </form>
</body>
</html>
