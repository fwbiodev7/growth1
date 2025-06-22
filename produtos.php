<?php
    // Inclui o arquivo de banco de dados para acesso às funções
    require_once 'banco.php';

    // Lista os produtos e categorias do banco de dados
    $produtos = listarProdutos();
    $categorias = listarCategorias();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&family=Lexend%3Awght%40400%3B500%3B700%3B900&family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Growth Falso - Administração de Produtos</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Variável CSS para o ícone de seta do select, se necessário */
        :root {
            --select-button-svg: url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2724px%27 height=%2724px%27 fill=%27rgb(184,157,158)%27 viewBox=%270 0 256 256%27%3e%3cpath d=%27M181.66,170.34a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-48-48a8,8,0,0,1,11.32-11.32L128,212.69l42.34-42.35A8,8,0,0,1,181.66,170.34Zm-96-84.68L128,43.31l42.34,42.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,85.66Z%27%3e%3c/path%3e%3c/svg%3e');
        }

        /* Estilos personalizados para o carrossel (se for usar o Bootstrap Carousel) */
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

        /* Estilos para o formulário e tabela no estilo Growth Falso */
        .form-card {
            background-color: #382929; /* Cor de fundo do card */
            border-radius: 0.75rem; /* rounded-xl do Tailwind */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            padding: 1.5rem; /* p-6 do Tailwind */
        }
        .form-label {
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block; /* Para que a label ocupe sua própria linha */
        }
        .form-input, .form-select {
            background-color: #261c1c; /* Cor de fundo dos inputs/selects */
            color: #fff;
            border: 1px solid #533c3d; /* Borda dos inputs/selects */
            /* AQUI: Ajustado para cantos mais arredondados */
            border-radius: 9999px; /* rounded-full do Tailwind para cantos totalmente arredondados */
            padding: 0.9375rem 1rem; /* Ajustei o padding horizontal para acomodar o arredondamento */
            width: 100%;
            outline: none; /* Remove o outline padrão */
            transition: border-color 0.2s ease-in-out;
        }
        .form-input:focus, .form-select:focus {
            border-color: #e62229; /* Cor da borda ao focar */
        }
        .form-select {
            /* Adiciona o ícone de seta customizado para o select */
            appearance: none; /* Remove a seta padrão do navegador */
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: var(--select-button-svg);
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.5em; /* Tamanho do ícone */
        }
        /* Estilos para a tabela */
        .custom-table {
            border-collapse: collapse; /* Remove espaçamento entre células */
            width: 100%;
        }
        .custom-table th, .custom-table td {
            padding: 1rem; /* Espaçamento interno */
            text-align: left;
            border-bottom: 1px solid #533c3d; /* Borda entre as linhas */
        }
        .custom-table thead {
            background-color: #261c1c; /* Fundo do cabeçalho */
        }
        .custom-table th {
            color: #fff;
            font-size: 0.875rem; /* text-sm */
            font-weight: 500; /* font-medium */
        }
        .custom-table tbody tr {
            background-color: #181111; /* Fundo das linhas do corpo */
        }
        .custom-table tbody tr:nth-child(odd) {
            /* Opcional: para linhas alternadas, se desejar */
            background-color: #1a1414;
        }
        .custom-table td {
            color: #fff;
            font-size: 0.875rem; /* text-sm */
            font-weight: 400; /* font-normal */
        }
        .custom-table td.description {
            color: #b89d9e; /* Cor para descrições, se houver */
        }
        .custom-table td.action-btn {
            color: #b89d9e; /* Cor para texto de ação */
            font-weight: 700; /* font-bold */
        }
    </style>
</head>
<body class="bg-[#181111] font-lexend text-white">
    <div
      class="relative flex size-full min-h-screen flex-col bg-[#181111] dark group/design-root overflow-x-hidden"
      style="font-family: Lexend, 'Noto Sans', sans-serif;"
    >
        <div class="layout-container flex h-full grow flex-col">
            <?php require_once 'navstitch.php'; ?>

            <div class="px-40 flex flex-1 justify-center py-5">
                <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
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

                    <div class="form-card my-6 mx-4"> <h3 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] mb-4">Cadastro de Produtos</h3>
                        <form method="post" action="adm_prod.php">
                            <div class="mb-4">
                                <label for="txt_nome" class="form-label">Nome:</label>
                                <input type="text" id="txt_nome" name="txt_nome" class="form-input" placeholder="Digite o nome do produto">
                            </div>
                            <div class="mb-4">
                                <label for="txt_descricao" class="form-label">Descrição:</label>
                                <textarea id="txt_descricao" name="txt_descricao" class="form-input min-h-36" placeholder="Digite a descrição do produto"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="txt_preco" class="form-label">Preço:</label>
                                <input type="text" id="txt_preco" name="txt_preco" class="form-input" placeholder="Digite o preço">
                            </div>
                            <div class="mb-6">
                                <label for="txt_categoria" class="form-label">Categoria:</label>
                                <select id="txt_categoria" name="txt_categoria" class="form-select">
                                    <?php if (empty($categorias)): ?>
                                        <option value="">Nenhuma categoria disponível</option>
                                    <?php else: ?>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?= htmlspecialchars($categoria['id']); ?>"><?= htmlspecialchars($categoria['nome']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <button
                                type="submit"
                                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#e62229] text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-[#d01c25] active:scale-95 transition-all duration-200 ease-in-out"
                            >
                                <span class="truncate">Salvar Produto</span>
                            </button>
                        </form>
                    </div>

                    <div class="px-4 py-3 @container">
                        <div class="flex overflow-hidden rounded-xl border border-[#533c3d] bg-[#181111]">
                            <table class="custom-table flex-1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome do Produto</th>
                                        <th>Descrição</th>
                                        <th>Preço</th>
                                        <th>Categoria</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($produtos)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-[#b89d9e] py-4">Nenhum produto cadastrado.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($produtos as $produto): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($produto['produto_id']); ?></td>
                                                <td><?= htmlspecialchars($produto['produto_nome']); ?></td>
                                                <td class="description"><?= htmlspecialchars($produto['produto_descricao']); ?></td>
                                                <td>R$ <?= htmlspecialchars(number_format($produto['produto_preco'], 2, ',', '.')); ?></td>
                                                <td><?= htmlspecialchars($produto['categoria_nome']); ?></td>
                                                <td class="action-btn">
                                                    <a href="adm_prod.php?id=<?= htmlspecialchars($produto['produto_id']); ?>"
                                                       class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-8 px-3 bg-red-600 text-white text-xs font-bold leading-normal tracking-[0.015em] hover:bg-red-700 active:scale-95 transition-all duration-200 ease-in-out">
                                                        <span class="truncate">Excluir</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <style>
                            @container(max-width:120px){.table-c155206f-765e-4fb2-b4c2-e26cdd516743-column-120{display: none;}}
                            @container(max-width:240px){.table-c155206f-765e-4fb2-b4c2-e26cdd516743-column-240{display: none;}}
                            @container(max-width:360px){.table-c155206f-765e-4fb2-b4c2-e26cdd516743-column-360{display: none;}}
                            @container(max-width:480px){.table-c155206f-765e-4fb2-b4c2-e26cdd516743-column-480{display: none;}}
                        </style>
                    </div>
                </div>
            </div>
            <footer class="flex justify-center">
                <div class="flex max-w-[960px] flex-1 flex-col">
                    <footer class="flex flex-col gap-6 px-5 py-10 text-center @container">
                        <div class="flex flex-wrap items-center justify-center gap-6 @[480px]:flex-row @[480px]:justify-around">
                            <a class="text-[#b89d9e] text-base font-normal leading-normal min-w-40 hover:text-gray-400 transition-colors duration-200" href="#">About Us</a>
                            <a class="text-[#b89d9e] text-base font-normal leading-normal min-w-40 hover:text-gray-400 transition-colors duration-200" href="#">Contact</a>
                            <a class="text-[#b89d9e] text-base font-normal leading-normal min-w-40 hover:text-gray-400 transition-colors duration-200" href="#">Privacy Policy</a>
                        </div>
                        <p class="text-[#b89d9e] text-base font-normal leading-normal">@2024 Growth Falso. All rights reserved.</p>
                    </footer>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>