<?php
    if (!isset($page)) exit;

    if ($_POST) {

        $id = trim($_POST["id"] ?? NULL);
        $nome = trim($_POST["nome"] ?? NULL);
        $email = trim($_POST["email"] ?? NULL);
        $senha = trim($_POST["senha"] ?? NULL);
        $senha2 = trim($_POST["senha2"] ?? NULL);
        $cpf = trim($_POST["cpf"] ?? NULL);
        $salario = trim($_POST["salario"] ?? NULL);
        $datanascimento = trim($_POST["datanascimento"] ?? NULL);
        $ativo = trim($_POST["ativo"] ?? NULL);

        $data = explode("/", $datanascimento);
        $datanascimento = $data[2]."-".$data[1]."-".$data[0];

        $salario = str_replace(".", "", $salario);
        $salario = str_replace(",", ".", $salario);

        if (empty($nome)) {

            echo "<script>mensagem('Preencha o nome do usuário','erro');</script>";
            exit;

        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            echo "<script>mensagem('Preencha com um e-mail válido','erro');</script>";
            exit;

        } 
        
        require "functions.php";

        if (validarCPF($cpf) != 1) {

            echo "<script>mensagem('Preencha com um CPF válido','erro');</script>";
            exit;

        } else if (empty($id)) {

            $senha = password_hash($senha, PASSWORD_BCRYPT);

            $sqlCadastro = "insert into usuario values (NULL, :nome, :email, :senha, :cpf, :salario, :datanascimento, :ativo)";
            $consultaCadastro = $pdo->prepare($sqlCadastro);
            $consultaCadastro->bindParam(":nome", $nome);
            $consultaCadastro->bindParam(":email", $email);
            $consultaCadastro->bindParam(":senha", $senha);
            $consultaCadastro->bindParam(":cpf", $cpf);
            $consultaCadastro->bindParam(":salario", $salario);
            $consultaCadastro->bindParam(":datanascimento", $datanascimento);
            $consultaCadastro->bindParam(":ativo", $ativo);

        } else if (empty($senha)) {

            $sqlCadastro = "update usuario set nome = :nome, email = :email, cpf = :cpf, datanascimento = :datanascimento, ativo = :ativo, salario = :salario
                where id = :id limit 1";
            $consultaCadastro = $pdo->prepare($sqlCadastro);
            $consultaCadastro->bindParam(":nome", $nome);
            $consultaCadastro->bindParam(":email", $email);
            $consultaCadastro->bindParam(":salario", $salario);
            $consultaCadastro->bindParam(":cpf", $cpf);
            $consultaCadastro->bindParam(":datanascimento", $datanascimento);
            $consultaCadastro->bindParam(":ativo", $ativo);
            $consultaCadastro->bindParam(":id", $id);

        } else {

            $senha = password_hash($senha, PASSWORD_BCRYPT);

            $sqlCadastro = "update usuario set nome = :nome, email = :email, senha = :senha, cpf = :cpf, datanascimento = :datanascimento, 
                ativo = :ativo, salario = :salario
                where id = :id limit 1";
            $consultaCadastro = $pdo->prepare($sqlCadastro);
            $consultaCadastro->bindParam(":nome", $nome);
            $consultaCadastro->bindParam(":email", $email);
            $consultaCadastro->bindParam(":senha", $senha);
            $consultaCadastro->bindParam(":salario", $salario);
            $consultaCadastro->bindParam(":cpf", $cpf);
            $consultaCadastro->bindParam(":datanascimento", $datanascimento);
            $consultaCadastro->bindParam(":ativo", $ativo);
            $consultaCadastro->bindParam(":id", $id);

        }

        if ($consultaCadastro->execute()) {

            echo "<script>mensagem('Cadastro realizado com sucesso','success','listar/usuario');</script>";
            exit;

        } else {

            echo "<script>mensagem('Erro ao salvar registro','erro');</script>";
            exit;

        }

    }
