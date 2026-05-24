<?php
session_start();

ini_set("display_errors", 1);
ini_set("display_startup_erros", 1);
error_reporting(E_ALL);

require "../config.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Administrativo - iMDB</title>

    <base href="http://<?= $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"] ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css?v=1">

    <link rel="icon" href="imgs/icone.jpeg">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script src="js/bindings/inputmask.binding.js"></script>
    <script src="js/jquery.inputmask.min.js"></script>
    <script>
        mensagem = function(msg, tipo, url = null) {
            Swal.fire({
                title: msg,
                confirmButtonText: "OK"
            }).then((result) => {
                if (tipo == "erro") history.back();
                else location.href = url;
            });
        }
    </script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="css/summernote-bs5.min.css" rel="stylesheet">
    <script src="js/summernote-bs5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>

<body>
    <?php

    if (($_POST) && (!isset($_SESSION["administrador"]))) {
        // se for post e não estiver logado ainda

        $email = trim($_POST["email"] ?? NULL);
        $senha = trim($_POST["senha"] ?? NULL);

        if (strlen($senha) < 6) {
            echo "<script>mensagem('Digite uma senha válida','erro');</script>";
            exit;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>mensagem('Digite um e-mail válido','erro');</script>";
            exit;
        }

        $sqlUsuario = "select id, nome, email, senha from usuario where email = :email AND ativo = 'Sim' limit 1";
        $consultaUsuario = $pdo->prepare($sqlUsuario);
        $consultaUsuario->bindParam(":email", $email);
        $consultaUsuario->execute();

        $dadosUsuario = $consultaUsuario->fetch(PDO::FETCH_OBJ);

        if (empty($dadosUsuario->id)) {
            echo "<script>mensagem('Usuário inválido ou desativado','erro');</script>";
            exit;
        } else if (!password_verify($senha, $dadosUsuario->senha)) {
            echo "<script>mensagem('Usuário inválido','erro');</script>";
            exit;
        } else {

            $_SESSION["administrador"] = array(
                "id" => $dadosUsuario->id,
                "nome" => $dadosUsuario->nome,
                "email" => $dadosUsuario->email
            );

            echo "<script>location.href='index.php'</script>";
        }
    } else if (!isset($_SESSION["administrador"])) {
        //se não estiver logado

        require "pages/login.php";

    } else {
        //se estiver logado

        $param = $_GET["param"] ?? "home";
        $param = explode("/", $param);

        if (count($param) == 1) {

            $page = "pages/{$param[0]}.php";
        } else {

            $page = "{$param[0]}/{$param[1]}.php";

        }

        if (file_exists($page)) {
    ?>

            <nav class="navbar navbar-expand-lg bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="../imgs/logo.svg" width="100px" alt="iMDB">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="cadastrar/categoria">Categorias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="cadastrar/filme">Filme</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="cadastrar/usuario">Usuário</a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Olá <?= $_SESSION["administrador"]["nome"] ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="sair">Sair</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container mt-3 mb-3">
            <?php

            // incluir página
            include $page;

            ?>
            </div>

            <footer class="bg-dark text-center p-3">
                <p>Desenvolvido por Administrador | Todos os direitos reservados</p>
            </footer>

    <?php

        } else include "pages/erro.php";
    }
    ?>



</body>

</html>