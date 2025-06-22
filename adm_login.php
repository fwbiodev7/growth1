<?php
require_once 'banco.php';
$email = $_POST['txt_email'] ?? '';
$senha = $_POST['txt_senha'] ?? '';
if (loginUsuario($email, $senha)) {
    header('Location: categorias.php');
    exit;
} else {
    header('Location: login.php?erro=1');
    exit;
    $erro = isset($_GET['erro']) ? $_GET['erro'] : '';
    if ($erro == 1) {
        $erro = "E-mail ou senha inválidos!";
    } else {
        $erro = "";
    }
}
?>