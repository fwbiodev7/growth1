<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header com Dropdown</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-black px-10 py-3 bg-black">
        <div class="flex items-center gap-4 text-white">
            <div class="size-4">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path></svg>
            </div>
            <img src="img/logo.svg" alt="Logo Growth Falso" class="h-8">
        </div>
        <div class="flex flex-1 justify-end gap-8 items-center">
            <div class="flex items-center gap-9">
                <a class="text-white text-lg hover:text-gray-300 transition-colors duration-200" href="indexstitch.php" title="Início">
                    <i class="fa-solid fa-house"></i>
                </a>
                <a class="text-white text-sm font-medium leading-normal hover:text-gray-300 transition-colors duration-200" href="https://www.instagram.com/fwbio7">Contato</a>
                
                <div class="relative" id="admin-dropdown-container"> 
                    <a class="text-white text-sm font-medium leading-normal hover:text-gray-300 transition-colors duration-200 cursor-pointer" id="adminDropdownToggle">
                        <i class="fa-solid fa-user-gear mr-2"></i> Administração
                    </a>
                    <ul id="adminDropdownMenu" class="absolute hidden 
                               bg-[#261c1c] border border-[#533c3d] 
                               rounded-2xl shadow-lg py-2 z-10 min-w-[180px]
                               opacity-0 scale-95 
                               transition-all duration-300 ease-out origin-top-right">
                        <li><a class="block px-4 py-2 text-white hover:bg-[#382929] transition-colors duration-200" href="produtosstitch.php"><i class="fa-solid fa-box mr-2"></i> Projetos</a></li>
                        <li><a class="block px-4 py-2 text-white hover:bg-[#382929] transition-colors duration-200" href="categorias.php"><i class="fa-solid fa-tags mr-2"></i> Categorias</a></li>
                        <li><a class="block px-4 py-2 text-white hover:bg-[#382929] transition-colors duration-200" href="imagens.php"><i class="fa-solid fa-image mr-2"></i> Imagens</a></li>
                    </ul>
                </div>
                </div>
                <a class="text-white text-sm font-medium leading-normal">Bem-vindo(a), Fabio ADM! </a>
            <div class="flex gap-2">
                <button
                    class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 bg-[#472426] text-white gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5 hover:bg-[#5a3134] transition-colors duration-200"
                >
                    <div class="text-white" data-icon="ShoppingCart" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                            <path
                                d="M222.14,58.87A8,8,0,0,0,216,56H54.68L49.79,29.14A16,16,0,0,0,34.05,16H16a8,8,0,0,0,0,16h18L59.56,172.29a24,24,0,0,0,5.33,11.27,28,28,0,1,0,44.4,8.44h45.42A27.75,27.75,0,0,0,152,204a28,28,0,1,0,28-28H83.17a8,8,0,0,1-7.87-6.57L72.13,152h116a24,24,0,0,0,23.61-19.71l12.16-66.86A8,8,0,0,0,222.14,58.87ZM96,204a12,12,0,1,1-12-12A12,12,0,0,1,96,204Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,192,204Zm4-74.57A8,8,0,0,1,188.1,136H69.22L57.59,72H206.41Z"
                            ></path>
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.getElementById('adminDropdownToggle');
            const dropdownMenu = document.getElementById('adminDropdownMenu');
            const dropdownContainer = document.getElementById('admin-dropdown-container');

            // Função para alternar a visibilidade do dropdown
            dropdownToggle.addEventListener('click', function(event) {
                event.stopPropagation(); // Impede que o clique se propague para o document e feche imediatamente
                const isHidden = dropdownMenu.classList.contains('hidden');

                if (isHidden) {
                    // Mostrar dropdown
                    dropdownMenu.classList.remove('hidden');
                    // Pequeno atraso para garantir que a remoção de 'hidden' seja processada antes das transições
                    setTimeout(() => {
                        dropdownMenu.classList.remove('opacity-0', 'scale-95');
                        dropdownMenu.classList.add('opacity-100', 'scale-100');
                    }, 10); 
                } else {
                    // Esconder dropdown
                    dropdownMenu.classList.remove('opacity-100', 'scale-100');
                    dropdownMenu.classList.add('opacity-0', 'scale-95');
                    // Atraso para que a transição de saída termine antes de adicionar 'hidden'
                    setTimeout(() => {
                        dropdownMenu.classList.add('hidden');
                    }, 300); // Deve ser igual ou maior que a duração da transição (duration-300)
                }
            });

            // Fechar dropdown ao clicar fora
            document.addEventListener('click', function(event) {
                // Verifica se o clique não foi dentro do container do dropdown
                if (!dropdownContainer.contains(event.target)) {
                    if (!dropdownMenu.classList.contains('hidden')) { // Se o dropdown estiver aberto
                        dropdownMenu.classList.remove('opacity-100', 'scale-100');
                        dropdownMenu.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            dropdownMenu.classList.add('hidden');
                        }, 300);
                    }
                }
            });
        });
    </script>

</body>
</html>