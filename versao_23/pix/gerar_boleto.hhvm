<?php
include 'db.php';

// Função para gerar um txid único
function gerar_txid($conn) {
    $caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $tamanho = rand(26, 35);
    do {
        $txid = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $txid .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        // Verificar se o txid já existe na tabela pix_info
        $sql = "SELECT COUNT(*) AS total FROM pix_info WHERE txid = '$txid'";
        $result = $conn->query($sql);
        if ($result) {
            $data = $result->fetch_assoc();
            if ($data['total'] == 0) {
                break; // txid não existe, sair do loop
            }
        } else {
            log_message("Erro ao verificar txid: " . $conn->error);
            break;
        }
    } while (true); // Continuar gerando até encontrar um txid único

    return $txid;
}

function log_message($message) {
    $log_file = 'gerar_boleto_log.txt';
    $time = date('Y-m-d H:i:s');
    $log_message = "[$time] $message" . PHP_EOL;
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

// Função para validar campos necessários
function validar_campos_necessarios($dado, $campos_necessarios) {
    foreach ($campos_necessarios as $campo) {
        if ($campo == 'cpf' && !isset($dado['cpf'])) {
            $dado['cpf'] = isset($dado['identificacao']) ? $dado['identificacao'] : ''; // Mapear 'identificacao' para 'cpf'
        }
        if (!isset($dado[$campo]) || empty($dado[$campo])) {
            log_message("Campo faltando ou vazio: $campo. Dados recebidos: " . json_encode($dado));
            return false;
        }
    }
    return true;
}

// Processar a solicitação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['dados'])) {
    $dados = json_decode($_POST['dados'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(array('error' => 'Dados JSON inválidos.'));
        log_message('Dados JSON inválidos: ' . json_last_error_msg());
        exit;
    }

    $requests_data = array();
    $original_data = array(); // Usar o txid como chave para o mapeamento
    $campos_necessarios = array('nome', 'cpf', 'valor', 'endereco', 'data_vencimento', 'descricao', 'id_cliente', 'id_lanc');

    foreach ($dados as $dado) {
        if (!validar_campos_necessarios($dado, $campos_necessarios)) {
            continue;
        }

        $txid = gerar_txid($conn);
        $requests_data[] = array(
            $txid,
            $dado['nome'],
            $dado['cpf'],
            floatval($dado['valor']),
            $dado['endereco'],
            $dado['data_vencimento'],
            $dado['descricao']
        );

        // Armazenar os dados originais usando o txid como chave
        $original_data[$txid] = array(
            'id_cliente' => $dado['id_cliente'],
            'id_lanc' => $dado['id_lanc'],
            'data_vencimento' => $dado['data_vencimento']
        );
    }

    if (!empty($requests_data)) {
        $json_data = escapeshellarg(json_encode($requests_data));
        $command = "python3.5 gera.py $json_data";
        log_message("Comando executado: $command");
        $output = shell_exec($command);
        log_message("Saída do script Python: $output");
        $boleto_results = json_decode($output, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $results = array();
            foreach ($boleto_results as $boleto_data) {
                if (isset($boleto_data['error'])) {
                    $results[] = $boleto_data;
                    log_message("Erro retornado pelo script Python: " . $boleto_data['error']);
                } else {
                    if (isset($boleto_data['txid']) && isset($boleto_data['qrcode']) && isset($boleto_data['pixCopiaECola']) && isset($boleto_data['status'])) {
                        $txid = $boleto_data['txid'];
                        if (isset($original_data[$txid])) {
                            $id_cliente = intval($original_data[$txid]['id_cliente']);
                            $id_lanc = intval($original_data[$txid]['id_lanc']);
                            $data_vencimento = $original_data[$txid]['data_vencimento'];

                            // Verificar se data_vencimento corresponde a datavenc em sis_lanc
                            $query = "SELECT datavenc FROM sis_lanc WHERE id = '{$id_lanc}'";
                            $result = $conn->query($query);
                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $datavenc = $row['datavenc'];

                                // Formatar as datas para comparação
                                $data_vencimento_formatada = date('Y-m-d', strtotime($data_vencimento));
                                $datavenc_formatada = date('Y-m-d', strtotime($datavenc));

                                if ($data_vencimento_formatada == $datavenc_formatada) {
                                    // Datas correspondem, prosseguir com a inserção
                                    $sql = "INSERT INTO pix_info (id_cliente, txid, qrcode, pix_copia_cola, data_criacao, status, id_lanc) VALUES (
                                        '{$id_cliente}',
                                        '{$boleto_data['txid']}',
                                        '{$boleto_data['qrcode']}',
                                        '{$boleto_data['pixCopiaECola']}',
                                        NOW(),
                                        '{$boleto_data['status']}',
                                        '{$id_lanc}'
                                    )";

                                    log_message("Executando SQL: $sql");
                                    if ($conn->query($sql) === TRUE) {
                                        $pix_info_query = "SELECT * FROM pix_info WHERE txid = '{$boleto_data['txid']}'";
                                        $pix_info_result = $conn->query($pix_info_query);
                                        if ($pix_info_result) {
                                            $pix_info = $pix_info_result->fetch_assoc();
                                            $results[] = $pix_info;
                                        } else {
                                            $results[] = array('error' => "Erro ao consultar pix_info: " . $conn->error);
                                            log_message("Erro ao consultar pix_info: " . $conn->error);
                                        }
                                    } else {
                                        $results[] = array('error' => "Erro ao inserir no banco de dados: " . $conn->error);
                                        log_message("Erro ao inserir no banco de dados: " . $conn->error);
                                    }
                                } else {
                                    // Datas não correspondem
                                    $results[] = array('error' => "Data de vencimento não corresponde para id_lanc: {$id_lanc}");
                                    log_message("Data de vencimento não corresponde para id_lanc: {$id_lanc}. data_vencimento: {$data_vencimento_formatada}, datavenc: {$datavenc_formatada}");
                                }
                            } else {
                                $results[] = array('error' => "id_lanc não encontrado ou erro na consulta: " . $conn->error);
                                log_message("Erro ao consultar sis_lanc para id_lanc: {$id_lanc}. Erro: " . $conn->error);
                            }
                        } else {
                            $results[] = array('error' => "Dados originais não encontrados para txid: {$txid}");
                            log_message("Dados originais não encontrados para txid: {$txid}");
                        }
                    } else {
                        $results[] = array('error' => "Dados insuficientes retornados do script Python.");
                        log_message("Dados insuficientes retornados do script Python: " . json_encode($boleto_data));
                    }
                }
            }
        } else {
            $results[] = array('error' => 'Resposta JSON inválida do script Python.');
            log_message('Resposta JSON inválida do script Python: ' . json_last_error_msg());
        }

        echo json_encode($results);
    } else {
        echo json_encode(array('error' => 'Nenhuma solicitação para processar.'));
    }
} else {
    echo json_encode(array('error' => 'Requisição inválida.'));
    log_message('Requisição inválida.');
}

$conn->close();
?>
