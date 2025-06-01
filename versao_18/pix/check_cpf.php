<?php
include 'db.php';

$cpf = $_POST['cpf'];

$sql = "SELECT login FROM `sis_cliente` WHERE cpf_cnpj = '$cpf'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Location: faturas.php?login=" . $row['login']);
} else {
    echo "CPF nao encontrado.";
   header("Location: index.php");
}

$conn->close();
?>

