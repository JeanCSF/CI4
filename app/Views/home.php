<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('conteudo') ?>
<?php

use App\Models\Todo;

function reverseDates($oldData)
{
    // $oldData = $value->entrada;
    $orgDate = $oldData;
    $date = str_replace('/', '-', $orgDate);
    $newDate = date("d/m/Y", strtotime($date));
    return $newDate;
}
?>
<!-- Delete Modal -->
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
<!-- Delete Modal -->

<!-- Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="taskModalLabel">Adicionar Tarefa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-6 offset-3">
                            <form action="" id="form" method="post">
                                <div class="form-group">
                                    <input type="text" placeholder="Nome da tarefa" name="job_name" id="job_name" value="" class="form-control" required>
                                    <input type="hidden" name="id_job" id="id_job" value="">
                                    <input type="hidden" id="editar" value="">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <input type="submit" value="" id="btnSubmit" onclick="" class="btn btn-success">
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Task Modal -->
<header class="container mt-5">
    <div class="row">
        <div class="col-3 offset-2 ">
            <h3>TODO LIST!</h3>
        </div>
        <div class="col-4 offset-1 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal" onclick="fillModalNewJob()">Criar Tarefa</button>
        </div>
    </div>
</header>
<hr>
<div class="container mt-1">
    <div class="row">
        <div class="col">
            <h3 class="ms-1 position-absolute top-25 start-0 mb-5"> Tarefas Totais: <strong>
                    <?php
                    $db = new Todo();
                    $alljobs = $db->select()->countAll();
                    echo $alljobs;
                    ?>
                </strong>
            </h3>
            <h6 class="ms-1 position-absolute top-50 start-0 mb-5">Tarefas Concluídas: <strong>
                    <a style="text-decoration: none;" class="text-muted" href="<?= site_url('main/done') ?>">
                        <?php
                            $alldone = $db->where('DATETIME_FINISHED !=', NULL)->countAllResults();
                            echo $alldone;
                        ?>
                    </a>

                </strong>
                <p class="mt-5">Não Concluídas: <strong>
                        <?php
                        $notdone = $db->where('DATETIME_FINISHED =', NULL)->countAllResults();
                        echo $notdone;
                        ?>
                    </strong>
                </p>
            </h6>

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
                                <td class="text-center"><?= reverseDates($job->DATETIME_CREATED) ?></td>
                                <td class="text-center"><?= isset($job->DATETIME_FINISHED) ? reverseDates($job->DATETIME_FINISHED) : 'Não finalizada' ?></td>
                                <td class="text-end">
                                    <?php if (empty($job->DATETIME_FINISHED)) : ?>
                                        <a href="<?= site_url('main/jobdone/' . $job->ID_JOB) ?>" class="btn btn-light btn-sm mx-1" title="Finalizar Tarefa">&#9680;</a>
                                        <a class="btn btn-light btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#taskModal" title="Editar Tarefa" onclick="fillModalEdit('<?= $job->ID_JOB ?>', '<?= $job->JOB ?>')">&#9997;</a>
                                    <?php else : ?>
                                        <button class="btn btn-light btn-sm mx-1" disabled>&#10004;</button>
                                        <button class="btn btn-light btn-sm mx-1" disabled>&#9997;</button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-light btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="fillModalDelete(<?= $job->ID_JOB ?>)">&#128465;</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row" id="pager">
                    <div class="col mt-1">
                        <?php
                        if ($pager) {
                            echo $pager->links();
                        }
                        ?>
                    </div>
                    <div class="col text-end">
                        <p>Mostrando <strong><?= count($jobs) ?></strong> de
                            <strong><?php
                                    if(site_url('main/done')){
                                        echo $alldone;
                                    }else {

                                        echo $alljobs;
                                    }
                                    ?></strong>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-2">
            <form class="d-flex position-absolute top-25 start-75" role="search">
                <input class="form-control ms-2 me-1" type="search" name="search" placeholder="Pesquisar" aria-label="Search">
                <input type="submit" value="&#128270;" class="btn btn-outline-primary">
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    function fillModalDelete(id) {
        modal = document.getElementById("deleteModal");
        btnDelete = modal.getElementsByClassName("btn-warning")[0];
        btnDelete.setAttribute('dado-alvo', id);

    }

    function fillModalNewJob() {
        frm = document.getElementById("form");
        frm.setAttribute('action', '<?= site_url('main/newjobsubmit') ?>')

        frmBtn = document.getElementById("btnSubmit");
        frmBtn.setAttribute('value', 'Gravar');
    }

    function fillModalEdit(id, job) {
        frm = document.getElementById("form");
        frm.setAttribute('action', '<?= site_url('main/editjobsubmit') ?>')

        frmBtn = document.getElementById("btnSubmit");
        frmBtn.setAttribute('value', 'Atualizar');

        frmId = document.getElementById("id_job");
        frmId.setAttribute('value', id);

        frmJob = document.getElementById("job_name");
        frmJob.setAttribute('value', job);

    }

    function deleteJob(id) {
        var id = btnDelete.getAttribute('dado-alvo', id);
        window.location.replace('main/deletar/' + id);
    }
</script>

<?= $this->endSection() ?>