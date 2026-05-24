<?php if (!isset($page)) exit; ?>
<?php

    $sqlCadastro = "select * from categoria order by categoria";
    $consultaCadastro = $pdo->prepare($sqlCadastro);
    $consultaCadastro->execute();

    $dadosCadastro = $consultaCadastro->fetchAll(PDO::FETCH_OBJ);


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
        <table class="table table-bordered table-striped m-2">
            <thead>
                <tr>
                    <td width="10%">ID</td>
                    <td width="70%">Nome da Categoria</td>
                    <td width="20%">Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($dadosCadastro as $dados) {
                        ?>
                        <tr>
                            <td><?= $dados->id ?></td>
                            <td><?= $dados->categoria ?></td>
                            <td>
                                <a href="cadastrar/categoria/<?= $dados->id ?>" class="btn btn-warning">
                                    Editar
                                </a>
                                <a href="javascript:excluir(<?= $dados->id ?>)" class="btn btn-danger">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function excluir(id) {
        Swal.fire({
            title: "Deseja realmente excluir este registro?",
            showCancelButton: true,
            confirmButtonText: "Excluir",
            cancelButtonText: "Cancelar"
        }).then((result) => {

            if (result.isConfirmed) 
                location.href = 'excluir/categoria/' + id;

        });
    }
</script>