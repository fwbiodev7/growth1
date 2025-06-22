<?php
require_once 'banco.php'; // Inclua seu arquivo de conexão e funções de banco de dados

// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id_cat = $_GET['cat'] ?? null; 

if ($id_cat) {
    $produtos = listarProdutosIndexCategoria($id_cat);
} else {
    $produtos = listarProdutosIndex();
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

    <title>Growth Falso - Início</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
      /* Estilos personalizados para os cards de produto */
      .product-card {
        background-color: #382929; /* Cor de fundo do card */
        border-radius: 0.75rem; /* rounded-xl do Tailwind */
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      }
      .product-card-img {
        width: 100%;
        height: 160px; /* Altura um pouco menor para as imagens */
        object-fit: contain; /* Ajusta a imagem dentro do container */
        background-color: #221112; /* Fundo para a imagem */
        padding: 0.75rem; /* Espaçamento interno reduzido */
      }
      .product-card-body {
        padding: 0.75rem; /* p-3 do Tailwind, reduzido */
      }
      .product-card-title {
        color: #fff;
        font-size: 1rem; /* text-base do Tailwind, reduzido */
        font-weight: 700; /* font-bold do Tailwind */
        line-height: 1.3; /* leading-tight ligeiramente menor */
        margin-bottom: 0.375rem; /* Margem menor */
      }
      .product-card-description {
        color: #c89295;
        font-size: 0.75rem; /* text-sm do Tailwind, reduzido */
        line-height: 1.4;
        margin-bottom: 0.375rem; /* Margem menor */
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Limita a descrição a 2 linhas */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      .product-card-price {
        color: #fff;
        font-size: 0.95rem; /* text-base do Tailwind, ligeiramente menor */
        font-weight: 700; /* font-bold do Tailwind */
        margin-bottom: 0.75rem; /* Margem menor */
      }
      .product-card-category {
        color: #c89295;
        font-size: 0.7rem; /* text-xs do Tailwind, ligeiramente menor */
        margin-top: 0.375rem; /* Margem menor */
      }

      /* Estilos para o banner carrossel */
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
    </style>
  </head>
  <body>
    <div class="relative flex size-full min-h-screen flex-col bg-black dark group/design-root overflow-x-hidden" style='font-family: Lexend, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <?php include 'navuser.php'; ?>

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
            <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Categorias</h2>
            <div class="flex gap-3 p-3 flex-wrap">
                <a href="index.php" class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full bg-[#e9242a] pl-4 pr-4 text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-[#d01c25] transition-colors duration-200">
                    <span class="truncate">📦 Todos os Produtos</span>
                </a>
                <?php foreach ($categorias as $categoria): ?>
                    <a href="index.php?cat=<?= $categoria['id']; ?>" class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full bg-[#472426] pl-4 pr-4 text-white text-sm font-medium leading-normal hover:bg-[#5a3134] transition-colors duration-200">
                        <span class="truncate"><?= htmlspecialchars($categoria['nome']); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Produtos em Destaque</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                <?php if (empty($produtos)): ?>
                    <p class="text-white text-lg px-4 col-span-full text-center">Nenhum produto encontrado nesta categoria.</p>
                <?php else: ?>
                    <?php foreach ($produtos as $produto): ?>
                        <div class="product-card flex flex-col">
                            <img src="<?= htmlspecialchars($produto['imagem_link']); ?>" 
                                 class="product-card-img" 
                                 alt="<?= htmlspecialchars($produto['produto_nome']); ?>">
                            <div class="product-card-body flex flex-col flex-grow">
                                <h5 class="product-card-title"><?= htmlspecialchars($produto['produto_nome']); ?></h5>
                                <p class="product-card-description"><?= htmlspecialchars($produto['produto_descricao']); ?></p>
                                <p class="product-card-price">R$ <?= number_format($produto['produto_preco'], 2, ',', '.'); ?></p>
                                <small class="product-card-category">Categoria: <?= htmlspecialchars($produto['categoria_nome']); ?></small>
                                <a href="detalhes.php?id=<?= $produto['produto_id']; ?>" 
                                   class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-9 px-3 mt-auto 
                                          bg-[#e9242a] text-white text-sm font-bold leading-normal tracking-[0.015em] 
                                          hover:bg-[#d01c25] active:scale-95 transition-all duration-200 ease-in-out">
                                    <span class="truncate">Comprar</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-center p-4">
                <a href="#" class="flex size-10 items-center justify-center">
                    <div class="text-white" data-icon="CaretLeft" data-size="18px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M165.66,202.34a8,8,0,0,1-11.32,11.32l-80-80a8,8,0,0,1,0-11.32l80-80a8,8,0,0,1,11.32,11.32L91.31,128Z"></path>
                        </svg>
                    </div>
                </a>
                <a class="text-sm font-bold leading-normal tracking-[0.015em] flex size-10 items-center justify-center text-white rounded-full bg-[#472426]" href="#">1</a>
                <a class="text-sm font-normal leading-normal flex size-10 items-center justify-center text-white rounded-full" href="#">2</a>
                <a class="text-sm font-normal leading-normal flex size-10 items-center justify-center text-white rounded-full" href="#">3</a>
                <a href="#" class="flex size-10 items-center justify-center">
                    <div class="text-white" data-icon="CaretRight" data-size="18px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path>
                        </svg>
                    </div>
                </a>
            </div>
          </div>
        </div>

        <footer class="flex justify-center">
          <div class="flex max-w-[960px] flex-1 flex-col">
            <footer class="flex flex-col gap-6 px-5 py-10 text-center @container">
              <div class="flex flex-wrap items-center justify-center gap-6 @[480px]:flex-row @[480px]:justify-around">
                <a class="text-[#c89295] text-base font-normal leading-normal min-w-40" href="#">Política de Privacidade</a>
                <a class="text-[#c89295] text-base font-normal leading-normal min-w-40" href="#">Termos de Serviço</a>
                <a class="text-[#c89295] text-base font-normal leading-normal min-w-40" href="#">Envio e Devoluções</a>
              </div>
              <div class="flex flex-wrap justify-center gap-4">
                <a href="#">
                  <div class="text-[#c89295]" data-icon="InstagramLogo" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160ZM176,24H80A56.06,56.06,0,0,0,24,80v96a56.06,56.06,0,0,0,56,56h96a56.06,56.06,0,0,0,56-56V80A56.06,56.06,0,0,0,176,24Zm40,152a40,40,0,0,1-40,40H80a40,40,0,0,1-40-40V80A40,40,0,0,1,80,40h96a40,40,0,0,1,40,40ZM192,76a12,12,0,1,1-12-12A12,12,0,0,1,192,76Z"
                      ></path>
                    </svg>
                  </div>
                </a>
                <a href="#">
                  <div class="text-[#c89295]" data-icon="TwitterLogo" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M247.39,68.94A8,8,0,0,0,240,64H209.57A48.66,48.66,0,0,0,168.1,40a46.91,46.91,0,0,0-33.75,13.7A47.9,47.9,0,0,0,120,88v6.09C79.74,83.47,46.81,50.72,46.46,50.37a8,8,0,0,0-13.65,4.92c-4.31,47.79,9.57,79.77,22,98.18a110.93,110.93,0,0,0,21.88,24.2c-15.23,17.53-39.21,26.74-39.47,26.84a8,8,0,0,0-3.85,11.93c.75,1.12,3.75,5.05,11.08,8.72C53.51,229.7,65.48,232,80,232c70.67,0,129.72-54.42,135.75-124.44l29.91-29.9A8,8,0,0,0,247.39,68.94Zm-45,29.41a8,8,0,0,0-2.32,5.14C196,166.58,143.28,216,80,216c-10.56,0-18-1.4-23.22-3.08,11.51-6.25,27.56-17,37.88-32.48A8,8,0,0,0,92,169.08c-.47-.27-43.91-26.34-44-96,16,13,45.25,33.17,78.67,38.79A8,8,0,0,0,136,104V88a32,32,0,0,1,9.6-22.92A30.94,30.94,0,0,1,167.9,56c12.66.16,24.49,7.88,29.44,19.21A8,8,0,0,0,204.67,80h16Z"
                      ></path>
                    </svg>
                  </div>
                </a>
                <a href="#">
                  <div class="text-[#c89295]" data-icon="FacebookLogo" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm8,191.63V152h24a8,8,0,0,0,0-16H136V112a16,16,0,0,1,16-16h16a8,8,0,0,0,0-16H152a32,32,0,0,0-32,32v24H96a8,8,0,0,0,0,16h24v63.63a88,88,0,1,1,16,0Z"
                      ></path>
                    </svg>
                  </div>
                </a>
              </div>
              <p class="text-[#c89295] text-base font-normal leading-normal">@2024 Growth Falso. Todos os direitos reservados.</p>
            </footer>
          </div>
        </footer>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>