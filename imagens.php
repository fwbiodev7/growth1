<?php
    require_once 'banco.php';
    $imagens = listarImagens();
    $produtos = listarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Growth Suplementos</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    
    
    <!--Navigator-->
    <?php require_once 'nav.php'; ?>
    
    <div class="container my-3">
        <div class="content">      
            
            <h3>Cadastro de Imagens</h3>
            
            <form method="post" action="adm_img.php">
                <div class="form-group">
                    <label>Link: </label>
                    <input type="text" name="txt_link" class="form-control">
                </div>
                <div class="form-group">
                    <label>Produto: </label>
                    <select name="txt_produto" class="form-control">
                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?= $produto['produto_id']; ?>"><?= $produto['produto_nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="Salvar" class="btn btn-primary mt-2">
            </form>

            <table class="table table-responsive table-striped table-bordered mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Link</th>
                        <th>Produto</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($imagens)): ?>
                        <tr>
                            <td colspan="3" class="text-center">Nenhuma imagem</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($imagens as $imagem): ?>
                            <tr>
                                <td><?php echo $imagem['imagem_id']; ?></td>
                                <td>
                                    <img src="<?php echo $imagem['imagem_link']; ?>" style="height: 200px; width: 420px; object-fit: cover;" class="rounded">
                                </td>
                                <td><?php echo $imagem['produto_nome']; ?></td>
                                <td>
                                    <a class="btn btn-danger" href="adm_img.php?id=<?php echo $imagem['imagem_id']; ?>">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </tbody>
            </table>
            
        </div>
    </div>

    <!-- Footer -->
    <?php include_once "footer.php"; ?>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>