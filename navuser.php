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
                
                <?php
    // Start the session (ensure this is at the very top of every page where you need to access session data)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Database connection details - REPLACE THESE WITH YOUR ACTUAL CREDENTIALS
    $host = "srv1664.hstgr.io";
    $dbname = "u344105464_growth";
    $username = "u344105464_usergrowth";
    $password = "Ind-2025";
    $charset = 'utf8mb4';

    $nomeDoUsuario = 'Usuário'; // Default value

    // Enable error reporting for debugging (remove or comment out in production)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Check the session for user_id
    if (isset($_SESSION['idusuario'])) {
        $idusuario = $_SESSION['idusuario'];

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Recommended for security

            // Prepare the SQL query - Make sure 'usuarios' and 'nome' match your database
            $stmt = $pdo->prepare("SELECT nome FROM tb_usuarios WHERE id = :idusuario");
            $stmt->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the user data
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData && isset($userData['nome'])) {
                $nomeDoUsuario = htmlspecialchars($userData['nome']); // Sanitize output
            } else {
                // This could mean the user ID in the session doesn't exist in the database
                error_log("User with ID " . $idusuario . " not found in the database.");
            }

        } catch (PDOException $e) {
            // Handle database connection errors
            error_log("Database Error: " . $e->getMessage());
            echo "Erro de conexão com o banco de dados. Verifique os logs para mais detalhes.";
            // You might want to display a more user-friendly message in production
        } finally {
            $pdo = null; // Close connection
        }
    } else {
        // If user_id is not set in the session, the user is likely not logged in
        // You might want to handle this differently based on your application's logic
        // For example, redirect to the login page.
    }
?>
<span class="text-white text-sm font-medium leading-normal">Bem-vindo(a), <?php echo $nomeDoUsuario; ?>!</span>

<?php
    // Debugging: Inspect the session data (remove or comment out in production)
    /*
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
    */
?>
                
            </div>
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