<?php
// banco.php

// Dados da conexão
$host = "srv1664.hstgr.io";
$db  = "u344105464_growth";
$user = "u344105464_usergrowth";
$pass = "Ind-2025";
$charset = 'utf8mb4'; // Define o charset para evitar problemas com caracteres especiais

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Define o modo de erro para exceções
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Define o modo de busca padrão para array associativo
    PDO::ATTR_EMULATE_PREPARES  => false,  // Desabilita a emulação de prepared statements para maior segurança e desempenho
];

// Cria a conexão PDO
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // A variável $pdo agora está definida e disponível globalmente onde este arquivo for incluído.
    // Ela é a sua conexão principal.
} catch (\PDOException $e) {
    // Se a conexão falhar, exibe o erro e para a execução do script.
    // Em produção, você registraria isso em um log e mostraria uma mensagem genérica.
    die("Falha na conexão com o banco de dados: " . $e->getMessage());
}

// --- Funções de Banco de Dados Refatoradas para Usar PDO ---
// Todas as suas funções agora devem usar $pdo (a conexão global) ou a função conectar_pdo()

// Novo: Função para conectar usando PDO (se quiser ter uma função para isso, mas $pdo já é global)
function conectar_pdo() {
    global $host, $db, $user, $pass, $charset, $options; // Pega as variáveis globais de conexão
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    try {
        $pdo_conn = new PDO($dsn, $user, $pass, $options);
        return $pdo_conn;
    } catch (\PDOException $e) {
        die("Falha na conexão com o banco de dados dentro da função: " . $e->getMessage());
    }
}

// Nova função para buscar produto por ID
function buscarProdutoPorId(PDO $pdo, int $produto_id): ?array
{
    try {
        $stmt = $pdo->prepare("SELECT id AS produto_id, nome AS produto_nome, preco AS produto_preco, imagem FROM tb_produtos WHERE id = :id");
        $stmt->bindParam(':id', $produto_id, PDO::PARAM_INT);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        // Adiciona a lógica para buscar o link da primeira imagem relacionada ao produto
        if ($produto) {
            $stmt_imagem = $pdo->prepare("SELECT link FROM tb_imagens WHERE id_produto = :produto_id LIMIT 1");
            $stmt_imagem->bindParam(':produto_id', $produto['produto_id'], PDO::PARAM_INT);
            $stmt_imagem->execute();
            $imagem = $stmt_imagem->fetch(PDO::FETCH_ASSOC);
            $produto['imagem_link'] = $imagem['link'] ?? null; // Se houver link, usa; senão, null
            var_dump($produto);
        }
        return $produto;
    } catch (PDOException $e) {
        // Em um ambiente de produção, você deveria logar esse erro
        error_log("Erro ao buscar produto por ID: " . $e->getMessage());
        return null;
    }
}


function inserirCategoria($nome, $descricao) {
    $pdo_conn = conectar_pdo(); // Usa a função de conexão PDO
    $stmt = $pdo_conn->prepare("INSERT INTO tb_categorias (nome, descricao) VALUES (:nome, :descricao)");
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $stmt->execute();
    // No PDO, o close() geralmente não é necessário para prepared statements,
    // a conexão é liberada quando o script termina ou o objeto PDO é destruído.
    // $stmt->closeCursor(); // Pode ser usado para liberar recursos imediatamente
    // $pdo_conn = null; // Fecha a conexão, se aberta dentro da função
}

function inserirImagem($link, $id_produto) {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->prepare("INSERT INTO tb_imagens (link, id_produto) VALUES (:link, :id_produto)");
    $stmt->bindParam(':link', $link, PDO::PARAM_STR);
    $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT); // id_produto é INT
    $stmt->execute();
}

function inserirProdutos($nome, $descricao, $preco, $categoria) {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->prepare("INSERT INTO tb_produtos (nome, descricao, preco, id_categoria) VALUES (:nome, :descricao, :preco, :categoria)");
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $stmt->bindParam(':preco', $preco, PDO::PARAM_STR); // Use STR para dinheiro ou FLOAT dependendo da coluna
    $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
    $stmt->execute();
}

function excluirCategoria($id) {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->prepare("DELETE FROM tb_categorias WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function excluirImagem($id) {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->prepare("DELETE FROM tb_imagens WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function excluirProduto($id) {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->prepare("DELETE FROM tb_produtos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function listarCategorias() {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->query("SELECT id, nome, descricao FROM tb_categorias"); // query() para SELECT simples sem parâmetros
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categorias;
}

function ListarProdutosDetalhes($id) {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->prepare("
        SELECT
            p.id AS produto_id,
            p.nome AS produto_nome,
            p.descricao AS produto_descricao,
            p.preco AS produto_preco,
            c.nome AS categoria_nome,
            i.link AS imagem_link
        FROM tb_produtos p
        LEFT JOIN tb_categorias c ON p.id_categoria = c.id
        LEFT JOIN tb_imagens i ON p.id = i.id_produto
        WHERE p.id = :id
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $produtos;
}

function listarProdutosIndexCategoria($id) {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->prepare("
        SELECT
            p.id AS produto_id,
            p.nome AS produto_nome,
            p.descricao AS produto_descricao,
            p.preco AS produto_preco,
            c.nome AS categoria_nome,
            i.link AS imagem_link
        FROM tb_produtos p
        LEFT JOIN tb_categorias c ON p.id_categoria = c.id
        LEFT JOIN tb_imagens i ON p.id = i.id_produto
        WHERE c.id = :id
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $produtos;
}

function listarProdutosIndex() {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->query("
        SELECT
            p.id AS produto_id,
            p.nome AS produto_nome,
            p.descricao AS produto_descricao,
            p.preco AS produto_preco,
            c.nome AS categoria_nome,
            i.link AS imagem_link
        FROM tb_produtos p
        LEFT JOIN tb_categorias c ON p.id_categoria = c.id
        LEFT JOIN tb_imagens i ON p.id = i.id_produto
    ");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categorias;
}

function listarImagens() {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->query("
        SELECT
            i.id AS imagem_id,
            i.link AS imagem_link,
            i.id_produto AS imagem_produto,
            p.nome AS produto_nome
        FROM tb_imagens i
        JOIN tb_produtos p ON i.id_produto = p.id
    ");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categorias;
}

function listarProdutos() {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->query("
        SELECT
            p.id AS produto_id,
            p.nome AS produto_nome,
            p.descricao AS produto_descricao,
            p.preco AS produto_preco,
            p.id_categoria AS produto_categoria,
            c.nome AS categoria_nome
        FROM tb_produtos p
        JOIN tb_categorias c ON p.id_categoria = c.id
    ");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categorias;
}

// Função de Login: Modificada para retornar o array completo do usuário ou null
function loginUsuario($email, $senha_digitada) { // Renomeado para clareza
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->prepare("SELECT idusuario, nome, email, senha, nivel FROM tb_usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // IMPORTANTE: Aqui você PRECISA verificar a senha hashed!
    // Se o campo 'senha' no banco for o hash da senha, use password_verify.
    // Ex: if ($usuario && password_verify($senha_digitada, $usuario['senha'])) {
    if ($usuario && $senha_digitada === $usuario['senha']) { // Cuidado: ainda comparando texto puro
        return $usuario; // Retorna todo o array do usuário em caso de sucesso
    }
    return null; // Retorna null em caso de falha no login
}


function inserirUsuario($nome, $email, $senha, $foto, $nivel) {
    $pdo_conn = conectar_pdo();
    // ATENÇÃO: HASH A SENHA AQUI ANTES DE INSERIR NO BANCO!
    // $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $pdo_conn->prepare("INSERT INTO tb_usuarios (nome, email, senha, foto, id_nivel) VALUES (:nome, :email, :senha, :foto, :nivel)");
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR); // Mude para $senha_hashed se usar hash
    $stmt->bindParam(':foto', $foto, PDO::PARAM_STR);
    $stmt->bindParam(':nivel', $nivel, PDO::PARAM_INT);
    $stmt->execute();
}

function listarUsuario() {
    $pdo_conn = conectar_pdo();
    $stmt = $pdo_conn->query("SELECT idusuario, nome, email, nivel FROM tb_usuarios"); // Não traga a senha!
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $usuarios;
}

// Bloco de processamento da ação 'inserirUsuario'
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao === 'inserirUsuario') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? null;
            $email = $_POST['email'] ?? null;
            $senha = $_POST['senha'] ?? null; // A senha virá aqui, deve ser hashed antes de inserir!
            $foto = $_POST['foto'] ?? null;
            $nivel = 2; // Nível padrão para novos usuários

            if ($nome && $email && $senha) { // 'foto' pode ser opcional dependendo do seu esquema
                inserirUsuario($nome, $email, $senha, $foto, $nivel);
                header('Location: indexuser.php'); // Redireciona para index.php após cadastro
                exit;
            } else {
                // Lidar com campos faltando no cadastro, talvez redirecionar de volta para o formulário de cadastro
                // header('Location: cadastro.php?erro=campos_vazios');
                // exit;
            }
        }
        // Se a ação 'inserirUsuario' foi chamada via GET, ou POST sem dados, redireciona para a página de cadastro.
        // Cuidado com '.php' sem nome de arquivo, pode causar erro.
        header('Location: cadastro.php'); // Redireciona para o formulário de cadastro
        exit;
    }
}
?>