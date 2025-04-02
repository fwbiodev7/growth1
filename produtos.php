<?php
    require_once 'banco.php';
    $produtos = listarProdutos();
    $categorias = listarCategorias();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layout Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Logo e Menu -->
        <?php require_once 'nav.php'; ?>
        

        <div class="row my-4 card p-4 shadow">
            <h3>Cadastro de Produtos</h3>
            <form method="post" action="adm_prod.php">
                <div class="form-group">
                    <label>Nome: </label>
                    <input type="text" name="txt_nome" class="form-control">
                </div>
                <div class="form-group">
                    <label>Descrição: </label>
                    <input type="text" name="txt_descricao" class="form-control">
                </div>
                <div class="form-group">
                    <label>Preço: </label>
                    <input type="text" name="txt_preco" class="form-control">
                </div>
                <div class="form-group">
                    <label>Categoria: </label>
                    <select name="txt_categoria" class="form-control">
                        <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id']; ?>"><?= $categoria['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="Salvar" class="btn btn-primary mt-2">
            </form>
        </div>

        <table class="table table-responsive table-striped table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produtos)): ?>
                    <tr>
                        <td colspan="3" class="text-center">Nenhum produto</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo $produto['produto_id']; ?></td>
                        <td><?php echo $produto['produto_nome']; ?></td>
                        <td><?php echo $produto['produto_descricao']; ?></td>
                        <td><?php echo $produto['produto_preco']; ?></td>
                        <td><?php echo $produto['categoria_nome']; ?></td>
                        <td><a class="btn btn-danger" href="adm_prod.php?id=<?php echo $produto['produto_id']; ?>">Excluir</a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        
        <!-- Rodapé -->
        <footer class="row bg-dark text-white text-center py-3">
            <div class="col-12">
                <p class="mb-0">&copy; 2024 Minha Loja. Todos os direitos reservados.</p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>