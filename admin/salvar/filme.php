<?php
    if (!isset($page)) exit;

    if ($_POST) {

        $id = trim($_POST["id"] ?? NULL);
        $titulo = trim($_POST["titulo"] ?? NULL);
        $original = trim($_POST["original"] ?? NULL);
        $ano = trim($_POST["ano"] ?? NULL);
        $categoria_id = trim($_POST["categoria_id"] ?? NULL);
        $youtube = trim($_POST["youtube"] ?? NULL);
        $sinopse = trim($_POST["sinopse"] ?? NULL);

        if (empty($titulo)) {

            echo "<script>mensagem('Preencha o titulo','erro');</script>";
            exit;

        } else if (empty($original)) {

            echo "<script>mensagem('Preencha o titulo original','erro');</script>";
            exit;

        } 
        
        require "functions.php";

        if (empty($id)) {

            $extensao = pathinfo($_FILES["capa"]["name"], PATHINFO_EXTENSION);

            $arquivo = $_SESSION["administrador"]["id"] . "_" . time() .".". $extensao;

            if (empty($_FILES["capa"]["name"])) {

                echo "<script>mensagem('Selecione uma imagem de capa','erro');</script>";
                exit;

            } else if (!move_uploaded_file($_FILES["capa"]["tmp_name"], "../arquivos/{$arquivo}")) {

                echo "<script>mensagem('Erro ao copiar arquivo','erro');</script>";
                exit;

            }

            redimensionarImagem("../arquivos/{$arquivo}", 800, 600);

            $sqlSalvar = "insert into filme values (NULL, :titulo, :original, :ano, :categoria_id, :youtube, :arquivo, :sinopse)";
            $consultaSalvar = $pdo->prepare($sqlSalvar);
            $consultaSalvar->bindParam(":titulo", $titulo);
            $consultaSalvar->bindParam(":original", $original);
            $consultaSalvar->bindParam(":ano", $ano);
            $consultaSalvar->bindParam(":categoria_id", $categoria_id);
            $consultaSalvar->bindParam(":youtube", $youtube);
            $consultaSalvar->bindParam(":arquivo", $arquivo);
            $consultaSalvar->bindParam(":sinopse", $sinopse);

        } else if (empty($_FILES["capa"]["name"])) {
            
            $sqlSalvar = "update filme set categoria_id = :categoria_id, titulo = :titulo, original = :original, ano = :ano, youtube = :youtube,
               sinopse = :sinopse where id = :id limit 1";
            $consultaSalvar = $pdo->prepare($sqlSalvar);
            $consultaSalvar->bindParam(":titulo", $titulo);
            $consultaSalvar->bindParam(":original", $original);
            $consultaSalvar->bindParam(":ano", $ano);
            $consultaSalvar->bindParam(":categoria_id", $categoria_id);
            $consultaSalvar->bindParam(":youtube", $youtube);
            $consultaSalvar->bindParam(":sinopse", $sinopse);
            $consultaSalvar->bindParam(":id", $id);

        } else {

            $extensao = pathinfo($_FILES["capa"]["name"], PATHINFO_EXTENSION);

            $arquivo = $_SESSION["administrador"]["id"] . "_" . time() .".". $extensao;

            if (empty($_FILES["capa"]["name"])) {

                echo "<script>mensagem('Selecione uma imagem de capa','erro');</script>";
                exit;

            } else if (!move_uploaded_file($_FILES["capa"]["tmp_name"], "../arquivos/{$arquivo}")) {

                echo "<script>mensagem('Erro ao copiar arquivo','erro');</script>";
                exit;

            }

            $sqlSalvar = "update filme set categoria_id = :categoria_id, titulo = :titulo, original = :original, ano = :ano, youtube = :youtube,
               sinopse = :sinopse, capa = :arquivo where id = :id limit 1";
            $consultaSalvar = $pdo->prepare($sqlSalvar);
            $consultaSalvar->bindParam(":titulo", $titulo);
            $consultaSalvar->bindParam(":original", $original);
            $consultaSalvar->bindParam(":ano", $ano);
            $consultaSalvar->bindParam(":categoria_id", $categoria_id);
            $consultaSalvar->bindParam(":youtube", $youtube);
            $consultaSalvar->bindParam(":arquivo", $arquivo);
            $consultaSalvar->bindParam(":sinopse", $sinopse);
            $consultaSalvar->bindParam(":id", $id);

        }

        if ($consultaSalvar->execute()) {

            echo "<script>mensagem('Registro Salvo com Sucesso','success','cadastrar/filme')</script>";

        } else {

            echo "<script>mensagem('Erro salvar filme','erro');</script>";

        }

    } else {

        echo "<script>mensagem('Erro ao acessar página','erro');</script>";

    }