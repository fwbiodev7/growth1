<?php
require_once 'banco.php'; // Inclua seu arquivo de conexão e funções de banco de dados

// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inicializa o carrinho na sessão se ele não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// --- Lógica de Manipulação do Carrinho ---

// Adicionar ou Atualizar Item no Carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $produto_id = $_POST['produto_id'] ?? null;
    $quantidade = $_POST['quantidade'] ?? 1;

    if ($produto_id) {
        $produto = buscarProdutoPorId($pdo, $produto_id);
        if ($produto) {
            if ($action === 'adicionar') {
    if (isset($_SESSION['carrinho'][$produto_id])) {
        $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade;
    } else {
        $_SESSION['carrinho'][$produto_id] = [
            'id' => $produto['produto_id'],
            'nome' => $produto['produto_nome'],
            'preco' => $produto['produto_preco'],
            'imagem_link' => $produto['imagem_link'],
            'quantidade' => $quantidade
        ];
    }
    // Deixe o var_dump para debug, mas comente o exit():
    echo '<pre>';
    var_dump($_SESSION['carrinho']);
    echo '</pre>';
    // exit(); <---- COMENTE ESTA LINHA
}
}
                // Mova o var_dump e exit() para cá para debug:
                /*
                echo '<pre>';
                var_dump($_SESSION['carrinho']);
                echo '</pre>';
                exit();
                */
            } elseif ($action === 'atualizar_quantidade') {
                if (isset($_SESSION['carrinho'][$produto_id])) {
                    $nova_quantidade = max(1, (int)$quantidade); // Garante que a quantidade mínima é 1
                    $_SESSION['carrinho'][$produto_id]['quantidade'] = $nova_quantidade;
                }
            }
        } else {
            echo "Erro: Produto com ID " . htmlspecialchars($produto_id) . " não encontrado.";
        }

    // Remover Item do Carrinho
    if ($action === 'remover' && isset($_POST['produto_id'])) {
        $produto_id_remover = $_POST['produto_id'];
        unset($_SESSION['carrinho'][$produto_id_remover]);
    }

    // Redireciona para evitar reenvio do formulário ao recarregar a página
    header('Location: carrinho.php');
    exit();

$carrinho_itens = $_SESSION['carrinho'];
$subtotal = 0;
foreach ($carrinho_itens as $item) {
    $subtotal += $item['preco'] * $item['quantidade'];
}

// Simulação de como adicionar um produto para testes:
// Remova ou comente esta linha após testar!
// $_SESSION['carrinho'][1] = ['id' => 1, 'nome' => 'Whey Protein Isolado', 'preco' => 120.00, 'imagem_link' => 'https://via.placeholder.com/80x80/221112/c89295?text=WP', 'quantidade' => 2];
// $_SESSION['carrinho'][2] = ['id' => 2, 'nome' => 'Creatina Monohidratada', 'preco' => 50.00, 'imagem_link' => 'https://via.placeholder.com/80x80/221112/c89295?text=CR', 'quantidade' => 1];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
        rel="stylesheet"
        as="style"
        onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Lexend%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Growth Falso - Carrinho</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Estilos personalizados compartilhados com outras páginas (copiados do index) */
        .custom-carousel {
            max-width: 1000px;
            margin: 20px auto;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        }
        .custom-carousel .carousel-item img {
            max-height: 350px;
            object-fit: cover;
        }

        /* Estilos para formulário (input, select, button) */
        .form-control-custom {
            background-color: #221112;
            border: 1px solid #533c3d;
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            width: 100%;
        }
        .form-control-custom:focus {
            outline: none;
            border-color: #e9242a;
            box-shadow: 0 0 0 3px rgba(233, 36, 42, 0.5);
        }
        .form-group-custom label {
            color: #c89295;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }
        .btn-primary-custom {
            background-color: #e9242a;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 700;
            transition: background-color 0.2s ease-in-out;
            cursor: pointer; /* Adicionado cursor pointer */
        }
        .btn-primary-custom:hover {
            background-color: #d01c25;
        }
        .btn-secondary-custom { /* Para botões como remover, etc. */
            background-color: #472426;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: background-color 0.2s ease-in-out;
            cursor: pointer;
        }
        .btn-secondary-custom:hover {
            background-color: #5a3134;
        }
        .btn-icon-custom { /* Para botões de ícone (ex: remover item do carrinho) */
            background: none;
            border: none;
            color: #c89295;
            font-size: 1.1rem;
            transition: color 0.2s ease-in-out;
            cursor: pointer;
        }
        .btn-icon-custom:hover {
            color: #e9242a;
        }


        /* Estilos para tabela */
        .table-custom {
            background-color: #382929;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .table-custom thead {
            background-color: #221112;
            color: #c89295;
            font-size: 0.875rem;
            text-transform: uppercase;
        }
        .table-custom th, .table-custom td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #533c3d;
            color: #fff;
        }
        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }
        .table-custom tbody tr:hover {
            background-color: #2e2222;
        }
        .text-center-custom {
            text-align: center;
            color: #c89295;
            padding: 1rem;
        }

        /* Estilo para imagem do item no carrinho */
        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: contain;
            background-color: #1a0d0e;
            border-radius: 0.5rem;
            padding: 0.25rem;
        }

        /* Estilos para controle de quantidade */
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
            background-color: #221112;
            border: 1px solid #533c3d;
            color: #fff;
            padding: 0.5rem;
            border-radius: 0.5rem;
        }
        .quantity-button {
            background-color: #472426;
            color: #fff;
            border: none;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .quantity-button:hover {
            background-color: #5a3134;
        }
        .quantity-button:disabled {
            background-color: #2e2222;
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <div class="relative flex size-full min-h-screen flex-col bg-black dark group/design-root overflow-x-hidden" style='font-family: Lexend, "Noto Sans", sans-serif;'>
        <div class="layout-container flex h-full grow flex-col">

            <?php require_once 'nav1.php'; ?>

            <div id="carouselExample" class="carousel slide custom-carousel" data-bs-ride="carousel">
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

            <div class="px-40 flex flex-1 justify-center py-5">
                <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
                    <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Seu Carrinho de Compras</h2>

                    <div class="p-4">
                        <?php if (empty($carrinho_itens)): ?>
                            <div class="bg-[#382929] rounded-xl shadow-lg p-6 text-center text-white text-lg">
                                Seu carrinho está vazio. <a href="index.php" class="text-[#e9242a] hover:underline">Continue comprando!</a>
                            </div>
                        <?php else: ?>
                            <div class="table-custom overflow-x-auto mb-6">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Produto</th>
                                            <th scope="col" class="px-6 py-3">Preço Unitário</th>
                                            <th scope="col" class="px-6 py-3">Quantidade</th>
                                            <th scope="col" class="px-6 py-3">Subtotal Item</th>
                                            <th scope="col" class="px-6 py-3">Remover</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($carrinho_itens as $item): ?>
                                            <tr class="border-b border-[#533c3d] hover:bg-[#2e2222]">
                                                <td class="px-6 py-4 flex items-center gap-4">
                                                    <img src="<?= htmlspecialchars($item['imagem_link'] ?? 'https://via.placeholder.com/80x80/221112/c89295?text=Img') ?>" alt="<?= htmlspecialchars($item['nome']); ?>" class="cart-item-image">
                                                    <span class="text-white font-medium"><?= htmlspecialchars($item['nome']); ?></span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">R$ <?= number_format($item['preco'], 2, ',', '.'); ?></td>
                                                <td class="px-6 py-4">
                                                    <form action="carrinho.php" method="POST" class="quantity-control">
                                                        <input type="hidden" name="action" value="atualizar_quantidade">
                                                        <input type="hidden" name="produto_id" value="<?= htmlspecialchars($item['id']); ?>">
                                                        <button type="submit" name="quantidade" value="<?= max(1, $item['quantidade'] - 1); ?>" class="quantity-button" <?= ($item['quantidade'] <= 1) ? 'disabled' : ''; ?>>-</button>
                                                        <input type="number" name="quantidade" value="<?= htmlspecialchars($item['quantidade']); ?>" min="1" class="quantity-input" readonly>
                                                        <button type="submit" name="quantidade" value="<?= $item['quantidade'] + 1; ?>" class="quantity-button">+</button>
                                                    </form>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></td>
                                                <td class="px-6 py-4">
                                                    <form action="carrinho.php" method="POST">
                                                        <input type="hidden" name="action" value="remover">
                                                        <input type="hidden" name="produto_id" value="<?= htmlspecialchars($item['id']); ?>">
                                                        <button type="submit" class="btn-icon-custom" title="Remover Item">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="bg-[#382929] rounded-xl shadow-lg p-6 flex flex-col items-end text-white">
                                <div class="text-xl font-bold mb-4">
                                    Subtotal: <span class="text-[#e9242a]">R$ <?= number_format($subtotal, 2, ',', '.'); ?></span>
                                </div>
                                <a href="checkout.php" class="btn-primary-custom w-full sm:w-auto text-center">
                                    Finalizar Compra <i class="fa-solid fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <footer class="flex justify-center">
                <div class="flex max-w-[960px] flex-1 flex-col">
                    <?php include_once "footer.php"; ?>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>