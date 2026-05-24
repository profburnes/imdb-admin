<h2 class="text-center">Olá <?= $_SESSION["administrador"]["nome"] ?>, seja bem-vindo!</h2>
<div class="row">
    <div class="col-12 col-md-4">
        <div class="card p-4 shadow text-center">
            <?php
                $sql = "select count(id) conta from categoria limit 1";
                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                $conta = $consulta->fetch(PDO::FETCH_OBJ)->conta;
            ?>
            <p>Existem <?= $conta ?> Categorias Cadastradas!</p>
            <p>
                <a href="cadastrar/categoria" class="btn btn-primary">
                    Cadastrar Categoria
                </a>
            </p>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card p-4 shadow text-center">
            <?php
                $sql = "select count(id) conta from filme limit 1";
                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                $conta = $consulta->fetch(PDO::FETCH_OBJ)->conta;
            ?>
            <p>Existem <?= $conta ?> Filmes Cadastrados!</p>
            <p>
                <a href="cadastrar/filme" class="btn btn-primary">
                    Cadastrar Filme
                </a>
            </p>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card p-4 shadow text-center">
            <?php
                $sql = "select count(id) conta from usuario limit 1";
                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                $conta = $consulta->fetch(PDO::FETCH_OBJ)->conta;
            ?>
            <p>Existem <?= $conta ?> Usuários Cadastrados!</p>
            <p>
                <a href="cadastrar/usuario" class="btn btn-primary">
                    Cadastrar Usuário
                </a>
            </p>
        </div>
    </div>
</div>