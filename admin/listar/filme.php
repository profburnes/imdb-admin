<?php if (!isset($page)) exit; ?>
<?php

    $sqlCadastro = "select f.id, f.titulo, f.ano, f.capa, c.categoria from filme f 
        inner join categoria c on (c.id = f.categoria_id)
        order by titulo";
    $consultaCadastro = $pdo->prepare($sqlCadastro);
    $consultaCadastro->execute();

    $dadosCadastro = $consultaCadastro->fetchAll(PDO::FETCH_OBJ);


?>
<div class="card shadow">
    <div class="card-header">
        <h2 class="float-start">Cadastro de Filmes</h2>
        <div class="float-end">
            <a href="cadastrar/filme" class="btn btn-success">Cadastrar Novo</a>
            <a href="listar/filme" class="btn btn-success">Listar</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped m-2">
            <thead>
                <tr>
                    <td width="15%">Capa</td>
                    <td width="10%">ID</td>
                    <td width="40%">Nome do Filme</td>
                    <td width="5%">Lançamento</td>
                    <td width="10%">Categoria</td>
                    <td width="20%">Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($dadosCadastro as $dados) {
                        ?>
                        <tr>
                            <td><img src="../arquivos/<?= $dados->capa ?>" class="w-100"></td>
                            <td><?= $dados->id ?></td>
                            <td><?= $dados->titulo ?></td>
                            <td><?= $dados->ano ?></td>
                            <td><?= $dados->categoria ?></td>
                            <td>
                                <a href="cadastrar/filme/<?= $dados->id ?>" class="btn btn-warning">
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
                location.href = 'excluir/filme/' + id;

        });
    }

    $(document).ready(function () {
        $('.table').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nada encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>