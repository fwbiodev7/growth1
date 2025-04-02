<?php
    require_once 'banco.php';
    $id=$_GET['id'];
    if(isset($id)){
        $produtos = ListarProdutosDetalhes($id);
    } else {
        header('Location: index.php');        
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Growth Suplementos Falso</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    
    
    <!--Navigator-->
    <?php require_once 'nav.php'; ?>
    
    <!--Banner-->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/01.webp" class="d-block w-100" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="img/02.webp" class="d-block w-100" alt="Banner 2">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>
<div class = "container my-3">
    <?php foreach ($produtos as $produto): ?>
    <div class= "content row">
        <div class="col-6"><img src="<?= $produto['imagem_link']; ?>"></div>
        <div class="col-6">
            <h3><?= $produto['produto_nome']; ?></h3>
            <p>Descrição: <?= $produto['produto_descricao']; ?></p>
            <p>Preço: <?= $produto['produto_preco']; ?></p>
            <p>Categoria: <?= $produto['categoria_nome']; ?></p>
            <a href="index.php" class="btn btn-danger">Voltar</a>
        </div>
    </div>
<?php endforeach; ?>
    <!-- Footer -->
    <?php include_once "footer.php"; ?>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>