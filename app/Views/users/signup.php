<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('conteudo') ?>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-sm-6 offset-3 col-8 offset-2">
            <div class="card p-4">
                <h3>Nova conta de usuário</h3>
                <hr>
                <?php
                helper('form');
                echo form_open('userscontroller/signupsubmit');
                ?>

                <?php if (isset($error)) : ?>
                    <p class="alert alert-danger text-center"><?php echo $error; ?></p>
                <?php endif; ?>
                <div class="row mb-3">
                    <input type="text" name="txtUser" class="form-control" placeholder="Usuário" required autofocus>
                </div>
                <div class="row mb-3">
                    <input type="password" class="form-control" name="txtPass" placeholder="Digite sua senha" required>
                </div>
                <div class="row mb-3">
                    <input type="password" class="form-control" name="txtPass2" placeholder="Confirme a senha digitada" required>
                </div>
                <div class="row mb-3">
                    <input type="email" class="form-control" name="txtEmail" placeholder="Email" required>
                </div>
                <div class="row mb-3">
                    <input type="text" class="form-control" name="txtName" placeholder="Nome" required>
                    <div class="text-center mt-2">
                        <a href="<?= site_url('/') ?>" class="btn btn-secondary">Cancelar</a>
                        <input class="btn btn-primary" type="submit" value="Criar conta">
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>