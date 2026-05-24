<?php
    if (!isset($page)) exit;

    if ($_POST) {

        $id = trim($_POST["id"] ?? NULL);
        $categoria = trim($_POST["categoria"] ?? NULL);

        if (empty($categoria)) {

            echo "<script>mensagem('Preencha a categoria','erro');</script>";
            exit;

        } else if (empty($id)) {

            $sqlSalvar = "insert into categoria values (NULL, :categoria)";
            $consultaSalvar = $pdo->prepare($sqlSalvar);
            $consultaSalvar->bindParam(":categoria", $categoria);

        } else {
            
            $sqlSalvar = "update categoria set categoria = :categoria where id = :id limit 1";
            $consultaSalvar = $pdo->prepare($sqlSalvar);
            $consultaSalvar->bindParam(":categoria", $categoria);
            $consultaSalvar->bindParam(":id", $id);

        }

        if ($consultaSalvar->execute()) {

            echo "<script>mensagem('Registro Salvo com Sucesso','success','cadastrar/categoria')</script>";

        } else {

            echo "<script>mensagem('Erro salvar categoria','erro');</script>";

        }

    } else {

        echo "<script>mensagem('Erro ao acessar página','erro');</script>";

    }