<div class="login">
    <div class="card shadow">
        <div class="card-header text-center">
            <h1>Sistema Admin</h1>
            <img src="../imgs/logo.svg" alt="iMDB" width="200px">
        </div>
        <div class="card-body">
            <form name="formLogin" method="post" data-parsley-validate="">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" required
                data-parsley-required-message="Digite seu e-mail"
                data-parsley-type-message="Insira um e-mail válido">
                <br>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control" required
                data-parsley-required-message="Digite a senha">
                <br>
                <button type="submit" class="btn btn-success w-100">
                    Efetuar Login
                </button>
            </form>
        </div>
    </div>
</div>