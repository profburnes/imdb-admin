<?php

    if (!isset($page)) exit;

    $id = $param[2] ?? NULL;

    if (empty($id)) {

        echo "<script>mensagem('Registro inválido','erro');</script>";

    } else {

        $sql = "select id from filme where categoria_id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dadosFilme = $consulta->fetch(PDO::FETCH_OBJ);

        if (!empty($dadosFilme->id)) {

            echo "<script>mensagem('Não foi possível excluir, pois existe um filme cadastrado com esta categoria','erro');</script>";

        } else {

            $sqlExcluir = "delete from categoria where id = :id limit 1";
            $consultaExcluir = $pdo->prepare($sqlExcluir);
            $consultaExcluir->bindParam(":id", $id);
            
            if ($consultaExcluir->execute()) {

                echo "<script>mensagem('Registro excluído','success','listar/categoria');</script>";

            } else {

                echo "<script>mensagem('Erro ao excluir categoria','erro');</script>";

            }

        }
    }