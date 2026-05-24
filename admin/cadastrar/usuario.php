<?php if (!isset($page)) exit; ?>
<?php

    $id = $param[2] ?? NULL;

    if (!empty($id)) {
        $sqlCadastro = "select *, date_format(datanascimento, '%d/%m/%Y') data 
            from usuario where id = :id limit 1";
        $consultaCadastro = $pdo->prepare($sqlCadastro);
        $consultaCadastro->bindParam(":id", $id);
        $consultaCadastro->execute();

        $dadosCadastro = $consultaCadastro->fetch(PDO::FETCH_OBJ);
    }

    $nome = $dadosCadastro->nome ?? NULL; 
    $email = $dadosCadastro->email ?? NULL; 
    $ativo = $dadosCadastro->ativo ?? NULL;  
    $datanascimento = $dadosCadastro->data ?? NULL; 
    $cpf = $dadosCadastro->cpf ?? NULL;
    $salario = $dadosCadastro->salario ?? 0;
    $salario = number_format($salario, 2, ",", ".");

?>
<div class="card shadow">
    <div class="card-header">
        <h2 class="float-start">Cadastro de Usuário</h2>
        <div class="float-end">
            <a href="cadastrar/usuario" class="btn btn-success">Cadastrar Novo</a>
            <a href="listar/usuario" class="btn btn-success">Listar</a>
        </div>
    </div>
    <div class="card-body">
        <p>Preencha todos os campos:</p>
        <form name="formCadastro" method="post" action="salvar/usuario" data-parsley-validate="">
            <div class="row">
                <div class="col-12 col-md-2">
                    <label for="id">ID</label>
                    <input type="text" name="id" id="id" value="<?= $id ?>" class="form-control" readonly>
                </div>
                <div class="col-12 col-md-6">
                    <label for="nome">Nome do Usuário</label>
                    <input type="text" name="nome" id="nome" value="<?= $nome ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
                <div class="col-12 col-md-4">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" value="<?= $email ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo"
                    data-parsley-type-message="Preencha com um e-mail válido">
                </div>
                <div class="col-12 col-md-6">
                    <label for="senha">Digite uma Senha</label>
                    <input type="password" name="senha" id="senha" value="" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
                <div class="col-12 col-md-6">
                    <label for="senha2">Redigite a Senha</label>
                    <input type="password" name="senha2" id="senha2" value="" class="form-control" required
                    data-parsley-equalto="#senha"
                    data-parsley-required-message="Preencha este campo"
                    data-parsley-equalto-message="As senhas digitadas não são iguais">
                </div>
                <div class="col-12 col-md-4">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" value="<?= $cpf ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
                <div class="col-12 col-md-4">
                    <label for="salario">Salário</label>
                    <input type="text" name="salario" id="salario" value="<?= $salario ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
                <div class="col-12 col-md-2">
                    <label for="datanascimento">Data de Nascimento</label>
                    <input type="text" name="datanascimento" id="datanascimento" value="<?= $datanascimento ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
                <div class="col-12 col-md-2">
                    <label for="ativo">Ativo</label>
                    <select name="ativo" id="ativo" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                        <option value=""></option>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>
                <script>
                    $("#ativo").val("<?= $ativo ?>");
                </script>
            </div>
            <br>
            <div class="float-end">
                <button type="submit" class="btn btn-success">
                    Salvar Dados
                </button>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#cpf').inputmask('999.999.999-99');
    $('#datanascimento').inputmask('99/99/9999');
    $('#salario').mask('000.000.000.000.000,00', {
        reverse: true
    });

    <?php
        if (!empty($id)) {
            ?>
            $('#senha').removeAttr('required').parsley().reset();
            $('#senha2').removeAttr('required').parsley().reset();
            <?php
        }
    ?>
});
</script>