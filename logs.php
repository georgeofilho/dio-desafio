<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include 'db_connect.php';

$sql = "SELECT l.id, u.nome AS usuario, m.nome AS mercadoria, l.operacao, l.data_operacao, l.quantidade
        FROM log_operacoes l
        JOIN usuarios u ON l.usuario_id = u.id
        JOIN mercadorias m ON l.mercadoria_id = m.id
        ORDER BY l.data_operacao DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logs de Operações</title>
</head>
<body>
    <h2>Logs de Operações</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Mercadoria</th>
            <th>Operação</th>
            <th>Data</th>
            <th>Quantidade</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['usuario']}</td>
                        <td>{$row['mercadoria']}</td>
                        <td>{$row['operacao']}</td>
                        <td>{$row['data_operacao']}</td>
                        <td>{$row['quantidade']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhum log encontrado</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
