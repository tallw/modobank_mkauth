<?php
require 'db.php';

try {
    // Consulta para pegar os dados da tabela webhook_logs
    $query = "
        SELECT w.recebido_em, p.txid, p.id_cliente 
        FROM webhook_logs w
        JOIN pix_info p ON w.txid = p.txid
    ";
    $stmt = $conn->query($query);
    if (!$stmt) {
        throw new Exception("Erro na consulta: " . $conn->error);
    }

    $webhookData = array();
    while ($row = $stmt->fetch_assoc()) {
        $webhookData[] = $row;
    }

    foreach ($webhookData as $data) {
        $datapag = $data['recebido_em'];
        $txid = $data['txid'];
        $id_cliente = $data['id_cliente'];

        // Atualização da tabela sis_lanc
        $updateQuery = "
            UPDATE sis_lanc 
            SET datapag = ?, 
                status = 'pago', 
                formapag = 'modobank', 
                num_recibos = 1
            WHERE id_cliente = ?
              AND txid = ?
        ";

        $updateStmt = $conn->prepare($updateQuery);
        if (!$updateStmt) {
            throw new Exception("Erro na preparação da atualização: " . $conn->error);
        }
        $updateStmt->bind_param('sis', $datapag, $id_cliente, $txid);
        $success = $updateStmt->execute();
        if (!$success) {
            throw new Exception("Erro na execução da atualização: " . $updateStmt->error);
        }
    }

    echo "Atualização concluída com sucesso!";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

$conn->close();
?>

