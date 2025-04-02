<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Logo à esquerda -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="img/logo.svg" height="90px" alt="Logo">
        </a>

        <!-- Botão responsivo -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Itens do menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fa-solid fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produtos.php"><i class="fa-solid fa-box"></i> Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categorias.php"><i class="fa-solid fa-tags"></i> Categorias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="imagens.php"><i class="fa-solid fa-envelope"></i> Imagens</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user-gear"></i> Administração
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="categorias.php"><i class="fa-solid fa-tags"></i> Categorias</a></li>
                        <li><a class="dropdown-item" href="produtos.php"><i class="fa-solid fa-box"></i> Produtos</a></li>
                        <li><a class="dropdown-item" href="imagens.php"><i class="fa-solid fa-image"></i> Imagens</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>