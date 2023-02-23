<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('conteudo') ?>
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Deletar Tarefa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Deseja deletar a tarefa:</h3>
                <h5 id="tarefa"></h5>
                <span class="text-danger">Esta ação é irreversível</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a type="button" class="btn btn-warning" id="btnDeletar" onclick="deleteJob()">Deletar</a>
            </div>
        </div>
    </div>
</div>
<header class="container">
    <div class="row">
        <div class="col">
            <h3>TODO LIST!</h3>
        </div>
        <div class="col text-end mb-5">
            <a href="<?= site_url('main/new_job') ?>" class="btn btn-primary">Criar Tarefa</a>
        </div>
    </div>
</header>
<div class="container mt-2">
    <div class="row">
        <div class="col-2">
            <h5 class="ms-1 position-absolute top-50 start-0"> Tarefas: <strong><?= count($jobs) ?></strong></h5>
        </div>
        <div class="col-8">
            <?php if (count($jobs) == 0) : ?>
                <h3 class="alert alert-warning text-center">Não existem tarefas!</h3>
            <?php else : ?>
                <table class="table table-hover">
                    <thead class="table table-dark">
                        <tr>
                            <th>Tarefa</th>
                            <th class="text-center">Data de Criação</th>
                            <th class="text-center">Data de Finalização</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job) : ?>
                            <tr>
                                <td><?= $job->JOB ?></td>
                                <td class="text-center"><?= $job->DATETIME_CREATED ?></td>
                                <td class="text-center"><?= $job->DATETIME_FINISHED ?></td>
                                <td class="text-end">
                                    <?php if (empty($job->DATETIME_FINISHED)) : ?>
                                        <a href="<?= site_url('main/jobdone/' . $job->ID_JOB) ?>" class="btn btn-light btn-sm mx-1" title="Finalizar Tarefa">&#9680;</a>
                                        <a href="<?= site_url('main/editJob/' . $job->ID_JOB) ?>" class="btn btn-light btn-sm mx-1" title="Editar Tarefa">&#9997;</a>
                                    <?php else : ?>
                                        <button class="btn btn-light btn-sm mx-1" disabled>&#10004;</button>
                                        <button class="btn btn-light btn-sm mx-1" disabled>&#9997;</button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-light btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="preencherModalDelete(<?= $job->ID_JOB ?>)">&#128465;</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row" id="pager">
                    <?php
                    if ($pager) {
                        echo $pager->links();
                    }

                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    function preencherModalDelete(id) {
        modal = document.getElementById("deleteModal");
        btnExcluir = modal.getElementsByClassName("btn-warning")[0];
        btnExcluir.setAttribute('dado-alvo', id);

    }

    function deleteJob(id) {
        var id = btnExcluir.getAttribute('dado-alvo', id);
        window.location.replace('main/deletar/' + id)
    }
</script>

<?= $this->endSection() ?>