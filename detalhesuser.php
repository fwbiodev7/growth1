<?php
    require_once 'banco.php';
    $id = $_GET['id'] ?? null;

    if ($id) {
        $produtos = ListarProdutosDetalhes($id);
    } else {
        header('Location: index.php');
        exit;
    }
    if ($id) {
        $produtos = ListarProdutosDetalhes($id);
    } else {
        header('Location: indexuser.php');
        exit;
    }
?>
<?php
session_start();

// Aqui você pode verificar qual página o usuário estava antes
$pagina_atual = basename($_SERVER['PHP_SELF']);
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

    <title>Growth Falso - Detalhes do Produto</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        /* Estilos personalizados compartilhados (do index e outras páginas) */
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

        /* Estilos específicos para a página de Detalhes do Produto */
        .produto-detalhes-card {
            background-color: #382929; /* Fundo do card de detalhes */
            border-radius: 1rem; /* Cantos arredondados */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Sombra */
            padding: 2.5rem; /* p-10 */
            display: flex;
            flex-wrap: wrap; /* Para quebrar a linha em telas menores */
            gap: 2rem; /* Espaçamento entre imagem e info */
            align-items: flex-start; /* Alinha no topo */
            color: #fff; /* Texto branco */
        }

        .produto-detalhes-imagem-container {
            flex: 1 1 400px; /* Cresce e encolhe, com base de 400px */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #221112; /* Fundo mais escuro para a imagem */
            border-radius: 0.75rem; /* rounded-xl */
            padding: 1.5rem; /* p-6 */
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5); /* Sombra interna sutil */
        }

        .produto-detalhes-imagem {
            max-width: 100%;
            max-height: 450px; /* Altura máxima maior para a imagem principal */
            object-fit: contain; /* Garante que a imagem inteira seja visível */
            border-radius: 0.5rem;
        }

        .produto-detalhes-info {
            flex: 1 1 500px; /* Cresce e encolhe, com base de 500px */
        }

        .produto-detalhes-info h2 {
            font-size: 2.25rem; /* text-4xl (aproximado) */
            font-weight: 700; /* font-bold */
            color: #fff; /* Texto branco */
            margin-bottom: 1rem;
        }

        .produto-detalhes-info p {
            font-size: 1.125rem; /* text-lg */
            color: #c89295; /* Cor para descrições e detalhes */
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .produto-preco-detalhes {
            font-size: 2.5rem; /* text-5xl (aproximado) */
            font-weight: 900; /* font-extrabold */
            color: #e9242a; /* Cor do preço (vermelho principal) */
            margin-top: 1.5rem;
            margin-bottom: 2rem;
        }

        .produto-preco-detalhes span {
            font-size: 1.5rem; /* Para o "R$" */
            font-weight: 700;
        }

        /* Botões */
        .btn-custom-voltar {
            background-color: #472426; /* Cor secundária (laranja escuro) */
            color: #fff;
            padding: 0.75rem 1.5rem; /* py-3 px-6 */
            border-radius: 0.5rem; /* rounded-lg */
            font-weight: 700; /* font-bold */
            transition: background-color 0.2s ease-in-out;
            display: inline-flex; /* Para alinhar ícone e texto */
            align-items: center;
            gap: 0.5rem; /* Espaçamento entre ícone e texto */
            text-decoration: none; /* Remover sublinhado do link */
        }
        .btn-custom-voltar:hover {
            background-color: #5a3134; /* Hover mais escuro */
            color: #fff; /* Manter cor do texto */
        }

        .btn-custom-comprar {
            background-color: #e9242a; /* Cor principal (vermelho) */
            color: #fff;
            padding: 0.75rem 1.5rem; /* py-3 px-6 */
            border-radius: 0.5rem; /* rounded-lg */
            font-weight: 700; /* font-bold */
            transition: background-color 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            margin-left: 1rem; /* Espaçamento entre os botões */
        }
        .btn-custom-comprar:hover {
            background-color: #d01c25; /* Hover mais escuro */
            color: #fff; /* Manter cor do texto */
        }
        
        /* Responsividade básica para os botões */
        @media (max-width: 768px) {
            .btn-actions-container {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }
            .btn-custom-comprar {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="relative flex size-full min-h-screen flex-col bg-black dark group/design-root overflow-x-hidden" style='font-family: Lexend, "Noto Sans", sans-serif;'>
        <div class="layout-container flex h-full grow flex-col">
            
            <?php require_once 'nav.php'; // Alterado de nav.php para navstitch.php ?>
            
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
                    <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Detalhes do Produto</h2>
                    
                    <div class="p-4">
                        <?php if (!empty($produtos)): ?>
                            <?php $produto = $produtos[0]; // Pega o primeiro (e único) produto se ListarProdutosDetalhes retornar um array ?>
                            <div class="produto-detalhes-card">
                                <div class="produto-detalhes-imagem-container">
                                    <img src="<?= htmlspecialchars($produto['imagem_link']); ?>" 
                                         alt="<?= htmlspecialchars($produto['produto_nome']); ?>" 
                                         class="produto-detalhes-imagem">
                                </div>
                                <div class="produto-detalhes-info">
                                    <h2 class="text-white"><?= htmlspecialchars($produto['produto_nome']); ?></h2>
                                    <p class="text-[#c89295]"><?= htmlspecialchars($produto['produto_descricao']); ?></p>
                                    <p class="text-[#c89295]"><strong>Categoria:</strong> <?= htmlspecialchars($produto['categoria_nome']); ?></p>
                                    
                                    <p class="produto-preco-detalhes">
                                        <span>R$</span> <?= number_format($produto['produto_preco'], 2, ',', '.'); ?>
                                    </p>
                                    
                                    <div class="btn-actions-container">
                                        <a onClick="javascript:history.go(-1)" 
                                           class="btn-custom-voltar">
                                            <i class="fa-solid fa-arrow-left"></i> Voltar
                                        </a>

                                        <form action="carrinho.php" method="POST" class="inline-block">
                                            <input type="hidden" name="action" value="adicionar">
                                            <input type="hidden" name="produto_id" value="<?= htmlspecialchars($produto['produto_id']); ?>">
                                            <input type="hidden" name="quantidade" value="1">
                                            <button type="submit" class="btn-custom-comprar">
                                                <a href="login.php"><i class="fa-solid fa-cart-shopping"></i> Faça login para poder comprar! 
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="bg-[#382929] rounded-xl shadow-lg p-6 text-center text-white text-lg">
                                Produto não encontrado.
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