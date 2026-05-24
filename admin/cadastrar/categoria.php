<?php if (!isset($page)) exit; ?>
<?php

    $id = $param[2] ?? NULL;

    if (!empty($id)) {
        $sqlCadastro = "select * from categoria where id = :id limit 1";
        $consultaCadastro = $pdo->prepare($sqlCadastro);
        $consultaCadastro->bindParam(":id", $id);
        $consultaCadastro->execute();

        $dadosCadastro = $consultaCadastro->fetch(PDO::FETCH_OBJ);
    }

    $categoria = $dadosCadastro->categoria ?? NULL; 

?>
<div class="card shadow">
    <div class="card-header">
        <h2 class="float-start">Cadastro de Categoria</h2>
        <div class="float-end">
            <a href="cadastrar/categoria" class="btn btn-success">Cadastrar Novo</a>
            <a href="listar/categoria" class="btn btn-success">Listar</a>
        </div>
    </div>
    <div class="card-body">
        <p>Preencha todos os campos:</p>
        <form name="formCadastro" method="post" action="salvar/categoria" data-parsley-validate="">
            <div class="row">
                <div class="col-12 col-md-2">
                    <label for="id">ID</label>
                    <input type="text" name="id" id="id" value="<?= $id ?>" class="form-control" readonly>
                </div>
                <div class="col-12 col-md-10">
                    <label for="categoria">Categoria</label>
                    <input type="text" name="categoria" id="categoria" value="<?= $categoria ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
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