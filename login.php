<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id, nome FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome);
        $stmt->fetch();
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario_nome'] = $nome;
        header("Location: mercadorias.php");
    } else {
        echo "Email ou senha inválidos!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
