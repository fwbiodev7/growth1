<?php
    require_once 'banco.php';
    $categorias = listarCategorias();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Growth</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    
    
    <!--Navigator-->
    <?php require_once 'nav.php'; ?>
    
    <div class="container my-3">
        <div class="content">      
            
            <h3>Cadastro de Categorias</h3>
            
            <form method="post" action="adm_cat.php">
                <div class="form-group">
                    <label>Nome: </label>
                    <input type="text" name="txt_nome" class="form-control">
                </div>
                <div class="form-group">
                    <label>Descrição: </label>
                    <input type="text" name="txt_descricao" class="form-control">
                </div>
                <input type="submit" value="Salvar" class="btn btn-primary mt-2">
            </form>

            <table class="table table-responsive table-striped table-bordered mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categorias)): ?>
                        <tr>
                            <td colspan="3" class="text-center">Nenhuma categoria</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?php echo $categoria['id']; ?></td>
                            <td><?php echo $categoria['nome']; ?></td>
                            <td><?php echo $categoria['descricao']; ?></td>
                            <td><a class="btn btn-danger" href="adm_cat.php?id=<?php echo $categoria['id']; ?>">Excluir</a></td>
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