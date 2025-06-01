<?php
session_start();

// Definir o tempo de sessão para 30 minutos
$session_timeout = 300; // 30 minutos em segundos
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    session_unset();
    session_destroy();
}
$_SESSION['last_activity'] = time();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash da senha fornecida pelo usuário
    $password_hash = hash('sha256', $password);

    // Conexão com o banco de dados
    $servername = "localhost";
    $db_username = "root";
    $db_password = "vertrigo";
    $dbname = "mkradius";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Preparar a consulta
    $stmt = $conn->prepare("SELECT idacesso, login FROM sis_acesso WHERE login = ? AND sha = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $username, $password_hash);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['username'] = $username;
            header("Location: inicio.php"); // Redireciona para o painel admin
            exit();
        } else {
            $error = "Username or Password is incorrect";
        }

        $stmt->close();
    } else {
        $error = "Erro ao preparar a consulta: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container form input {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container form button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container form button:hover {
            background-color: #0056b3;
        }
        .login-container .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

