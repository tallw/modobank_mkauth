<?php
include '../db.php'; // Certifique-se de que o caminho para db.php está correto

if (isset($_GET['nome']) && !empty($_GET['nome'])) {
    $nome = $_GET['nome'] . '%'; // Adiciona o curinga % para busca parcial

    // Verificar se a conexão com o banco de dados foi estabelecida
    if (!$conn) {
        echo json_encode(array('success' => false, 'message' => 'Conexão com o banco de dados falhou: ' . mysqli_connect_error()));
        exit;
    }

    // Buscar o login do cliente com base no nome
    $sql = "SELECT login, nome FROM sis_cliente WHERE nome LIKE ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $nome);
        $stmt->execute();
        $stmt->bind_result($login, $nome_encontrado);

        $resultados = array();
        while ($stmt->fetch()) {
            $resultados[] = array('login' => $login, 'nome' => $nome_encontrado);
        }

        if (count($resultados) > 0) {
            echo json_encode(array('success' => true, 'resultados' => $resultados));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Cliente não encontrado.'));
        }

        $stmt->close();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Erro na consulta do cliente: ' . $conn->error));
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Nome do cliente não fornecido.'));
}
?>

