<?php
require_once 'banco.php';
// Inicia a sessão se ainda não estiver iniciada (Boa prática do seu index.php)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$categorias = listarCategorias();
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

    <title>Growth Falso - Categorias</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        /* Estilos personalizados para o carrossel (DO SEU INDEX.PHP) */
        .custom-carousel {
            max-width: 1000px; /* Largura máxima maior para o carrossel */
            margin: 20px auto; /* Centraliza o carrossel e adiciona margem vertical */
            border-radius: 1rem; /* Cantos arredondados com Tailwind rounded-xl */
            overflow: hidden; /* Garante que os cantos arredondados apareçam */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4); /* Sombra para destacar */
        }
        .custom-carousel .carousel-item img {
            max-height: 350px; /* Altura máxima maior para as imagens do banner */
            object-fit: cover; /* Garante que a imagem cubra a área, cortando se necessário */
        }

        /* Estilos para o formulário e tabela (adaptados para o tema escuro do index) */
        .form-control-custom {
            background-color: #221112; /* Fundo mais escuro */
            border: 1px solid #533c3d; /* Borda sutil */
            color: #fff; /* Texto branco */
            padding: 0.75rem 1rem;
            border-radius: 0.5rem; /* rounded-lg */
            width: 100%;
        }
        .form-control-custom:focus {
            outline: none;
            border-color: #e9242a; /* Borda vermelha no foco */
            box-shadow: 0 0 0 3px rgba(233, 36, 42, 0.5); /* Sombra de foco vermelha */
        }
        .form-group-custom label {
            color: #c89295; /* Cor dos labels */
            font-size: 0.875rem; /* text-sm */
            font-weight: 500; /* font-medium */
            margin-bottom: 0.5rem;
            display: block;
        }
        .btn-primary-custom {
            background-color: #e9242a; /* Cor do botão principal */
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 700; /* font-bold */
            transition: background-color 0.2s ease-in-out;
        }
        .btn-primary-custom:hover {
            background-color: #d01c25; /* Cor de hover mais escura */
        }

        .table-custom {
            background-color: #382929; /* Fundo da tabela */
            border-radius: 0.75rem; /* rounded-xl */
            overflow: hidden; /* Para os cantos arredondados */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .table-custom thead {
            background-color: #221112; /* Fundo do cabeçalho da tabela */
            color: #c89295; /* Cor do texto do cabeçalho */
            font-size: 0.875rem; /* text-sm */
            text-transform: uppercase;
        }
        .table-custom th, .table-custom td {
            padding: 1rem 1.5rem; /* px-6 py-4 */
            border-bottom: 1px solid #533c3d; /* Borda entre as linhas */
            color: #fff; /* Cor do texto das células */
        }
        .table-custom tbody tr:last-child td {
            border-bottom: none; /* Remover borda da última linha */
        }
        .table-custom tbody tr:hover {
            background-color: #2e2222; /* Cor de hover da linha */
        }
        .text-center-custom { /* Para o 'Nenhuma categoria' */
            text-align: center;
            color: #c89295;
            padding: 1rem;
        }
        .action-icon {
            color: #c89295; /* Cor dos ícones de ação */
            transition: color 0.2s ease-in-out;
        }
        .action-icon:hover {
            color: #e9242a; /* Cor de hover para os ícones */
        }
    </style>
</head>
<body>
    <div class="relative flex size-full min-h-screen flex-col bg-black dark group/design-root overflow-x-hidden" style='font-family: Lexend, "Noto Sans", sans-serif;'>
        <div class="layout-container flex h-full grow flex-col">
            
            <?php require_once 'navstitch.php'; ?>
            
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
                    <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Gerenciar Categorias</h2>
                    
                    <div class="p-4">
                        <div class="bg-[#382929] rounded-xl shadow-lg p-6 mb-8">
                            <h3 class="text-white text-xl font-bold mb-4">Adicionar Nova Categoria</h3>
                            <form method="post" action="adm_cat.php">
                                <div class="mb-4 form-group-custom">
                                    <label for="txt_nome">Nome:</label>
                                    <input type="text" id="txt_nome" name="txt_nome" class="form-control-custom" required>
                                </div>
                                <div class="mb-6 form-group-custom">
                                    <label for="txt_descricao">Descrição:</label>
                                    <input type="text" id="txt_descricao" name="txt_descricao" class="form-control-custom" required>
                                </div>
                                <input type="submit" value="Salvar Categoria" class="btn-primary-custom cursor-pointer">
                            </form>
                        </div>

                        <div class="table-custom overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">ID</th>
                                        <th scope="col" class="px-6 py-3">Nome</th>
                                        <th scope="col" class="px-6 py-3">Descrição</th>
                                        <th scope="col" class="px-6 py-3">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($categorias)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center-custom">Nenhuma categoria encontrada.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <tr class="border-b border-[#533c3d] hover:bg-[#2e2222]">
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($categoria['id']); ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($categoria['nome']); ?></td>
                                                <td class="px-6 py-4"><?= htmlspecialchars($categoria['descricao']); ?></td>
                                                <td class="px-6 py-4 flex gap-3 items-center">
                                                    <a href="editar_categoria.php?id=<?= htmlspecialchars($categoria['id']); ?>" class="action-icon" title="Editar">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                    <a href="adm_cat.php?id=<?= htmlspecialchars($categoria['id']); ?>" class="action-icon" onclick="return confirm('Tem certeza que deseja excluir esta categoria?');" title="Excluir">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
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