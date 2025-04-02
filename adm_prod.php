<?php
    require_once 'banco.php';
    $id=$_GET['id'];
    if(isset($id)){
        excluirProduto($id);
        header('Location: produtos.php');
    }
    $nome = $_POST['txt_nome'];
    $descricao = $_POST['txt_descricao'];
    $preco = $_POST['txt_preco'];
    $categoria = $_POST['txt_categoria'];
    inserirProdutos($nome, $descricao, $preco, $categoria);
    header('Location: produtos.php');
?>