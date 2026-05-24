<?php

    if (!isset($page)) exit;

    $id = $param[2] ?? NULL;

    if (empty($id)) {

        echo "<script>mensagem('Registro inválido','erro');</script>";

    } else {

        $sqlFilme = "select capa from filme where id = :id limit 1";
        $consultaFilme = $pdo->prepare($sqlFilme);
        $consultaFilme ->bindParam(":id", $id);
        $consultaFilme ->execute();

        $dadosFilme  = $consultaFilme ->fetch(PDO::FETCH_OBJ);
       
        $sqlExcluir = "delete from filme where id = :id limit 1";
        $consultaExcluir = $pdo->prepare($sqlExcluir);
        $consultaExcluir->bindParam(":id", $id);
        
        if ($consultaExcluir->execute()) {

            unlink("../arquivos/{$dadosFilme->capa}");

            echo "<script>mensagem('Registro excluído','success','listar/filme');</script>";

        } else {

            echo "<script>mensagem('Erro ao excluir filme','erro');</script>";

        }


    }