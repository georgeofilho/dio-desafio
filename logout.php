<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
session_start();
session_destroy();
header("Location: login.php");
?>
