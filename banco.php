<?php
function conectar() {
    $mysqli = new mysqli("localhost", "root", "", "growth");    
    if ($mysqli->connect_error) {
        die("Falha: ".$mysqli->connect_error);
    }    
    return $mysqli;
}
function inserirCategoria($nome, $descricao) {
    $mysqli = conectar();
    $stmt = $mysqli->prepare("
        INSERT INTO tb_categorias 
        (nome, descricao) 
        VALUES (?, ?)
    ");
    $stmt->bind_param("ss", $nome, $descricao);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}
function inserirImagem($link, $id_produto) {
    $mysqli = conectar();
    $stmt = $mysqli->prepare("
        INSERT INTO tb_imagens 
        (link, id_produto) 
        VALUES (?, ?)
    ");
    $stmt->bind_param("sd", $link, $id_produto);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}
function inserirProdutos($nome, $descricao, $preco, $categoria) {
    $mysqli = conectar();
    $stmt = $mysqli->prepare("
        INSERT INTO tb_produtos 
        (nome, descricao, preco, id_categoria) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("ssdd", $nome, $descricao, $preco, $categoria);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

function excluirCategoria($id) {
    $mysqli = conectar();
    $stmt = $mysqli->prepare("
    DELETE FROM tb_categorias WHERE id = ?");
    $stmt->bind_param("i", $id);    
    $stmt->execute();   
    $stmt->close();
    $mysqli->close();
}
function excluirImagem($id) {
    $mysqli = conectar();
    $stmt = $mysqli->prepare("
    DELETE FROM tb_imagens WHERE id = ?");
    $stmt->bind_param("i", $id);    
    $stmt->execute();   
    $stmt->close();
    $mysqli->close();
}
function excluirProduto($id) {
    $mysqli = conectar();
    $stmt = $mysqli->prepare("
    DELETE FROM tb_produtos WHERE id = ?");
    $stmt->bind_param("i", $id);    
    $stmt->execute();   
    $stmt->close();
    $mysqli->close();
}

function listarCategorias() {
    $mysqli = conectar();
    $sql = "SELECT id, nome, descricao 
    FROM tb_categorias";
    $result = $mysqli->query($sql);
    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
    $mysqli->close();
    return $categorias;
}
function ListarProdutosDetalhes($id) {
    $mysqli = conectar();
    $stmt = $mysqli->prepare("SELECT 
        p.id AS produto_id,
        p.nome AS produto_nome,
        p.descricao AS produto_descricao,
        p.preco AS produto_preco,
        c.nome AS categoria_nome,
        i.link AS imagem_link
    FROM tb_produtos p
    LEFT JOIN tb_categorias c ON p.id_categoria = c.id
    LEFT JOIN tb_imagens i ON p.id = i.id_produto
    WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produtos = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $mysqli->close();
    return $produtos;
}
function listarProdutosIndexCategoria($id) {
    $mysqli = conectar();
    $stmt = $mysqli->prepare("SELECT 
        p.id AS produto_id,
        p.nome AS produto_nome,
        p.descricao AS produto_descricao,
        p.preco AS produto_preco,
        c.nome AS categoria_nome,
        i.link AS imagem_link
    FROM tb_produtos p
    LEFT JOIN tb_categorias c ON p.id_categoria = c.id
    LEFT JOIN tb_imagens i ON p.id = i.id_produto
    WHERE c.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produtos = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $mysqli->close();
    return $produtos;
}
function listarProdutosIndex() {
    $mysqli = conectar();
    $sql = "SELECT 
    p.id AS produto_id,
    p.nome AS produto_nome,
    p.descricao AS produto_descricao,
    p.preco AS produto_preco,
    c.nome AS categoria_nome,
    i.link AS imagem_link
    FROM tb_produtos p
    LEFT JOIN tb_categorias c 
    ON p.id_categoria = c.id
    LEFT JOIN tb_imagens i 
    ON p.id = i.id_produto;";
    $result = $mysqli->query($sql);
    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
    $mysqli->close();
    return $categorias;
}
function listarImagens() {
    $mysqli = conectar();
    $sql = "SELECT 
    i.id AS imagem_id, 
    i.link AS imagem_link, 
    i.id_produto AS imagem_produto, 
    p.nome AS produto_nome 
    FROM tb_imagens i
    JOIN tb_produtos p ON i.id_produto = p.id;
    ";
    $result = $mysqli->query($sql);
    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
    $mysqli->close();
    return $categorias;
}
function listarProdutos() {
    $mysqli = conectar();
    $sql = "SELECT 
    p.id AS produto_id, 
    p.nome AS produto_nome, 
    p.descricao AS produto_descricao, 
    p.preco AS produto_preco, 
    p.id_categoria AS produto_categoria,
    c.nome AS categoria_nome
    FROM tb_produtos p
    JOIN tb_categorias c 
    ON p.id_categoria = c.id;
    ";
    $result = $mysqli->query($sql);
    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
    $mysqli->close();
    return $categorias;
}

?>
