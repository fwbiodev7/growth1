<?php
    require_once 'banco.php';
    $id=$_GET['id'];
    if(isset($id)){
        excluirImagem($id);
        header('Location: imagens.php');
    }
    $link = $_POST['txt_link'];
    $produto = $_POST['txt_produto'];
    inserirImagem($link, $produto);
    header('Location: imagens.php');

    
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