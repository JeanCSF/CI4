<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('conteudo') ?>
<?php

use App\Models\Todo;

$db = new Todo();
$alltasks = $db->select()->countAll();
$alldone = $db->where('DATETIME_FINISHED !=', NULL)->countAllResults();
$notdone = $db->where('DATETIME_FINISHED =', NULL)->countAllResults();
$baseurl = base_url('/');
$doneurl = site_url('main/done');




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

<header class="container">
    <div class="row">
        <div class="col-4 ">
            <h3>
                <?php if(isset($done)): ?>
                    Concluídas
                <?php else: ?>
                    Todas as tarefas
                <?php endif; ?>
            </h3>
        </div>
        <div class="col-5 offset-1 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal" onclick="fillModalNewJob()">Criar Tarefa</button>
        </div>
    </div>
</header>
<hr>
<div class="container mt-1">
    <div class="row justify-content-md-center">
        <div class="col-lg-8 col-md-auto col-sm-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item <?= isset($done) || isset($search)? '' :'active'?>"<?= isset($done)? '' : 'aria-current="page"'?>>
                    <?= isset($done) || isset($search)? "<a  href='$baseurl'>Home</a>" : "Home"?></li>
                    
                    <?= isset($search) && empty($done)?
                        "<li class='breadcrumb-item active' aria-current='page'>Pesquisa</li>" : '' ?>
            
                    <?=isset($done) && empty($search)?'<li class="breadcrumb-item active" aria-current="page">Concluídas</li>' : '' ?>
                    <?= isset($search) && isset($done)?
                        "<li class='breadcrumb-item'><a href='$doneurl'>Concluídas</a></li>
                        <li class='breadcrumb-item active' aria-current='page'>Pesquisa</li>" : '' ?>
                </ol>
            </nav>
            <?php if (count($jobs) == 0) : ?>
                <h3 class="alert alert-warning text-center"><?= isset($done)?'Não existem tarefas concluídas para esta pesquisa' : 'Não existem tarefas'?></h3>
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
                        <p>Mostrando <strong><?= count($jobs) ?></strong> de <strong><?= $alljobs ?></strong></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-sm-auto col-lg-auto col-md-auto">
            <div class="card text-bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">Tarefas</div>
                <div class="card-body">
                    <h6 class="card-title">Totais: <strong><?= $alltasks ?></strong></h6>
                    <h6 class="card-title">Concluídas: <strong><a style="text-decoration: none;" class="text-success" href="<?= site_url('main/done') ?>"><?= $alldone ?></a></strong></h6>
                    <h6 class="card-title">Não Concluídas: <strong class="text-warning"><?= $notdone ?></strong></h6>
                </div>
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