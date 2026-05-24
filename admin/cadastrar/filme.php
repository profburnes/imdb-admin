<?php if (!isset($page)) exit; ?>
<?php

    $id = $param[2] ?? NULL;

    if (!empty($id)) {
        $sqlCadastro = "select * from filme where id = :id limit 1";
        $consultaCadastro = $pdo->prepare($sqlCadastro);
        $consultaCadastro->bindParam(":id", $id);
        $consultaCadastro->execute();

        $dadosCadastro = $consultaCadastro->fetch(PDO::FETCH_OBJ);
    }

    $titulo = $dadosCadastro->titulo ?? NULL; 
    $original = $dadosCadastro->original ?? NULL; 
    $ano = $dadosCadastro->ano ?? NULL; 
    $categoria_id = $dadosCadastro->categoria_id ?? NULL; 
    $youtube = $dadosCadastro->youtube ?? NULL; 
    $capa = $dadosCadastro->capa ?? NULL; 
    $sinopse = $dadosCadastro->sinopse ?? NULL; 

?>
<div class="card shadow">
    <div class="card-header">
        <h2 class="float-start">Cadastro de Filme</h2>
        <div class="float-end">
            <a href="cadastrar/filme" class="btn btn-success">Cadastrar Novo</a>
            <a href="listar/filme" class="btn btn-success">Listar</a>
        </div>
    </div>
    <div class="card-body">
        <p>Preencha todos os campos:</p>
        <form name="formCadastro" method="post" action="salvar/filme" data-parsley-validate="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-md-2">
                    <label for="id">ID</label>
                    <input type="text" name="id" id="id" value="<?= $id ?>" class="form-control" readonly>
                </div>
                <div class="col-12 col-md-10">
                    <label for="titulo">Título do Filme</label>
                    <input type="text" name="titulo" id="titulo" value="<?= $titulo ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
                <div class="col-12 col-md-10">
                    <label for="original">Título Original</label>
                    <input type="text" name="original" id="original" value="<?= $original ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
                <div class="col-12 col-md-2">
                    <label for="ano">Ano Lançamento</label>
                    <input type="number" name="ano" id="ano" value="<?= $ano ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
                <div class="col-12 col-md-4">
                    <label for="categoria_id">Categoria de Filme</label>
                    <select name="categoria_id" id="categoria_id" class="form-control" required 
                    data-parsley-required-message="Selecione uma categoria">
                        <option value=""></option>
                        <?php
                            $sqlCategoria = "select id, categoria from categoria order by categoria";
                            $consultaCategoria = $pdo->prepare($sqlCategoria);
                            $consultaCategoria->execute();

                            $dadosCategoria = $consultaCategoria->fetchAll(PDO::FETCH_OBJ);

                            foreach ($dadosCategoria as $dados) {
                                ?>
                                <option value="<?= $dados->id ?>"><?= $dados->categoria ?></option>
                                <?php
                            }

                        ?>
                    </select>
                    <script>
                        $("#categoria_id").val(<?= $categoria_id ?>);
                    </script>
                </div>
                <div class="col-12 col-md-4">
                    <label for="youtube">Cód Youtube</label>
                    <input type="text" name="youtube" id="youtube" value="<?= $youtube ?>" class="form-control" required
                    data-parsley-required-message="Preencha este campo">
                </div>
                <div class="col-12 col-md-4">
                    <label for="capa">Capa do Filme</label>
                    <input type="file" name="capa" id="capa" class="form-control">
                    <?php
                        if (!empty($capa)) {
                            ?>
                            <a href="../arquivos/<?= $capa ?>" title="Capa" target="_blank">Imagem de Capa</a>
                            <?php
                        }
                    ?>
                </div>
                <div class="col-12 col-md-12">
                    <label for="sinopse">Sinopse do Filme</label>
                    <textarea name="sinopse" id="sinopse" required class="form-control"
                    data-parsley-required-message="Preencha este campo"><?= $sinopse ?></textarea>
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
<script src="lang/summernote-pt-BR.js"></script>
<script>
    $(document).ready(function() {
      $('#sinopse').summernote({
        height: 200,
        lang: 'pt-BR'
      });
    });
</script>