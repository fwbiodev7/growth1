<?php
    require_once 'banco.php';
    $id=$_GET['id'];
    if(isset($id)){
        excluirCategoria($id);
        header('Location: categorias.php');
    }
    $nome = $_POST['txt_nome'];
    $descricao = $_POST['txt_descricao'];
    inserirCategoria($nome, $descricao);
    header('Location: categorias.php');
    $nome = isset($_POST['txt_nome']) ? trim($_POST['txt_nome']) : '';
    $descricao = isset($_POST['txt_descricao']) ? trim($_POST['txt_descricao']) : '';
    $id = isset($_GET['id']) ? trim($_GET['id']) : '';
    

    if (empty($nome) || empty($descricao)) {
        header('Location: categorias.php?msg=true');
    } else {
        inserirCategoria($nome, $descricao);
        header('Location: categorias.php');
    }

    if(empty($id)){
        header('Location: categorias.php?msg=true');
    } else {
        excluirCategoria($id);
        header('Location: categorias.php');
    }
        
?>