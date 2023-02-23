<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO!</title>
    <link rel="stylesheet" href="<?= base_url('/assets/bootstrap.min.css')?>">
</head>

<body>
    <navbar class="navbar navbar-expand-lg bg-light mb-2">
        <ul class="text-light  navbar-nav me-auto mb-1 mb-lg-0">
            <li class="nav-item">
                <a href="<?php echo base_url('/') ?>" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Sobre</a>
            </li>
        </ul>
    </navbar>

            <?= $this->renderSection('conteudo') ?>

    <footer class="fixed-bottom">
        <div class="bg-dark text-light text-center fs-4">
            &copy; <?php echo date('Y') ?>
        </div>
    </footer>

    <script src="<?= base_url('assets/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/popper.min.js') ?>"></script>

    <?= $this->renderSection("script"); ?>
</body>
</html>