<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('conteudo') ?>

<header class="container">
    <div class="row">
        <div class="col p-4">
            <h3>TODO LIST!</h3>
        </div>
        <div class="col text-end p-4">
            <?php if(isset($editar)): ?>
                <h3>Editar Tarefa: <?= $job->ID_JOB ?></h3>
            <?php else: ?>
                <h3>Nova Tarefa</h3>
            <?php endif; ?>
        </div>
    </div>
</header>
<hr>

<?php
helper('form');
if(isset($editar)){
    echo form_open('main/editjobsubmit');
} else {
    echo form_open('main/newjobsubmit');
}
?>
<div class="container">
    <div class="row">
        <div class="col-4 offset-4">
            <div class="form-group">
                <label for="job_name">Nome da tarefa:</label>
                <input type="text" name="job_name" value="<?= isset($editar) ? $job->JOB : '' ?>" class="form-control" required>
                <input type="hidden" name="id_job" value="<?= isset($editar) ? $job->ID_JOB : '' ?>">
            </div>
            <div class="row mt-2">
                <div class="col">
                    <a href="<?= site_url('main')?>" class="btn btn-danger">Cancelar</a>
                </div>
                <div class="col text-end">
                    <input type="submit" value="<?= (!empty($editar))? 'Atualizar' : 'Gravar'?>" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close() ?>

<?= $this->endSection() ?>