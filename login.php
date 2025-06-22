<?php
session_start(); // Inicia a sessão no topo do arquivo

require_once 'banco.php'; // Certifique-se de que este arquivo conecta ao seu banco de dados e retorna a conexão ($pdo)

// Verifica se o formulário foi submetido (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega diretamente os valores do POST
    $email_digitado = $_POST['email'] ?? '';
    $senha_digitada = $_POST['senha'] ?? ''; // ATENÇÃO: Nunca armazene senhas em texto puro!

    if (empty($email_digitado) || empty($senha_digitada)) {
        $mostrarMensagem = true;
        $mensagem_erro = "Por favor, preencha todos os campos.";
    } else {
        try {
            // Prepara e executa a consulta SQL para encontrar o usuário
            // A consulta busca o usuário pelo email
            $stmt = $pdo->prepare("SELECT id, nome, email, senha, id_nivel FROM tb_usuarios WHERE email = :email");
            $stmt->bindParam(':email', $email_digitado, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se o usuário foi encontrado e se a senha está correta
            // IMPORTANTE: Em produção, você deve usar password_verify() para senhas hashed!
            if ($usuario && $senha_digitada === $usuario['senha']) { // Substitua $usuario['senha'] pelo hash da senha no banco e use password_verify()
                // Login bem-sucedido!
                $_SESSION['listarUsuario'] = $usuario['nome']; // Armazena o nome do usuário na sessão
                $_SESSION['idusuario'] = $usuario['id']; // Opcional: armazena o ID do usuário

                // Verifica se o nome do usuário é "Fabio ADM" para redirecionar para a página de administrador
                if ($usuario['nome'] === 'Fabio ADM') {
                    header('Location: indexadm.php');
                    exit; // Importante para parar a execução e garantir o redirecionamento
                } else {
                    // Redireciona para a página do usuário padrão
                    header('Location: indexuser.php');
                    exit; // Importante para parar a execução e garantir o redirecionamento
                }
            } else {
                // Credenciais inválidas
                $mostrarMensagem = true;
                $mensagem_erro = "Email ou senha incorretos.";
            }
        } catch (PDOException $e) {
            // Erro de banco de dados
            $mostrarMensagem = true;
            $mensagem_erro = "Erro ao tentar fazer login. Tente novamente mais tarde.";
            // Em um ambiente de produção, registre o erro detalhado em logs (ex: error_log($e->getMessage());)
            // mas não o exiba diretamente ao usuário por segurança.
        }
    }
}
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

    <title>Stitch Design - Login</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        /* Estilos para animação da mensagem de erro */
        .mensagem-animacao {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }
        .mensagem-animacao.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
  </head>
  <body>
    <div class="relative flex size-full min-h-screen flex-col bg-black dark group/design-root overflow-x-hidden" style='font-family: Lexend, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <?php include 'navstitch.php'; ?>

        <div class="flex flex-1 justify-center items-center py-5">
          <div class="layout-content-container flex flex-col w-[512px] max-w-[512px] py-5 flex-1">
            <h2 class="text-white tracking-light text-[28px] font-bold leading-tight px-4 text-center pb-3 pt-5">Acessar sua Conta</h2>

            <?php if ($mostrarMensagem): ?>
                <div id="mensagem" class="mensagem-animacao <?php echo $mostrarMensagem ? 'show' : ''; ?> p-4 bg-red-800 text-white rounded-lg mb-4 text-center">
                    <?php echo $mensagem_erro; ?>
                </div>
                <script>
                    // Remove a mensagem após alguns segundos com animação
                    setTimeout(function() {
                        const mensagemDiv = document.getElementById('mensagem');
                        if (mensagemDiv) {
                            mensagemDiv.classList.remove('show');
                            setTimeout(function() {
                                mensagemDiv.remove();
                            }, 300); // Tempo igual à transição de opacidade
                        }
                    }, 5000); // 5 segundos
                </script>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                  <label class="flex flex-col min-w-40 flex-1">
                    <input
                      name="email"
                      type="email"
                      placeholder="Email"
                      class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#382929] focus:border-none h-14 placeholder:text-[#b89d9e] p-4 text-base font-normal leading-normal"
                      autocomplete="email"
                      value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    />
                  </label>
                </div>
                <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                  <label class="flex flex-col min-w-40 flex-1">
                    <input
                      name="senha"
                      type="password"
                      placeholder="Senha"
                      class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#382929] focus:border-none h-14 placeholder:text-[#b89d9e] p-4 text-base font-normal leading-normal"
                      autocomplete="current-password"
                    />
                  </label>
                </div>
                <p class="text-[#b89d9e] text-sm font-normal leading-normal pb-3 pt-1 px-4 text-center underline">
                    <a href="#">Esqueceu a senha?</a>
                </p>
                <div class="flex px-4 py-3">
                  <button
                    type="submit"
                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 flex-1 bg-[#e9242a] text-white text-sm font-bold leading-normal tracking-[0.015em]
                    hover:bg-[#d01c25] active:scale-95 transition-all duration-200 ease-in-out"
                  >
                    <span class="truncate">Entrar</span>
                  </button>
                </div>
                <p class="text-[#b89d9e] text-sm font-normal leading-normal pb-3 pt-1 px-4 text-center underline">
                    Não tem uma conta? <a href="cadastro.php">Cadastre-se</a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>