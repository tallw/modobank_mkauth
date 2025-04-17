<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: inicio.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Boleto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.1/css/OverlayScrollbars.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <style>
        .logout-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .logout-button button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-button button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'navbar.php'; ?>
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <h2 class="mt-5">Buscar Cliente</h2>
                    <form id="searchForm">
                        <div class="form-group">
                            <label for="nome">Nome do Cliente:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                    <div id="result" class="mt-3"></div>
                    <div id="boletoResult" class="mt-3"></div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <script>
    $(document).ready(function() {
        $('#searchForm').on('submit', function(event) {
            event.preventDefault();
            var nome = $('#nome').val();

            $.ajax({
                url: 'buscar_cliente.php',
                method: 'GET',
                data: { nome: nome },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        var html = '<div class="alert alert-success"><ul>';
                        $.each(data.resultados, function(index, cliente) {
                            html += '<li>' + cliente.nome + ' - <button class="btn btn-primary gerar-boleto" data-login="' + cliente.login + '">Gerar Boleto</button></li>';
                        });
                        html += '</ul></div>';
                        $('#result').html(html);
                    } else {
                        $('#result').html('<div class="alert alert-danger">' + data.message + '</div>');
                    }
                }
            });
        });

        $(document).on('click', '.gerar-boleto', function() {
            var login = $(this).data('login');

            $.ajax({
                url: 'gerar_modobank.php',
                method: 'GET',
                data: { login: login },
                success: function(response) {
                    $('#boletoResult').html('<div class="alert alert-success">Boleto gerado com sucesso!</div>');
                    setTimeout(function() {
                        $('#boletoResult').html('');
                        $('#result').html('');
                        $('#nome').val('');
                    }, 3000);
                },
                error: function() {
                    $('#boletoResult').html('<div class="alert alert-danger">Erro ao gerar o boleto. Tente novamente.</div>');
                }
            });
        });

        $('#logoutForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'logout.php',
                method: 'POST',
                success: function() {
                    window.location.href = 'index.php';
                }
            });
        });
    });
    </script>
</body>
</html>

