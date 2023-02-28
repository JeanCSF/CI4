<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO!</title>
    <link rel="stylesheet" href="<?= base_url('/assets/bootstrap.min.css') ?>">
    <style>
        #pager li {
            width: 25px;
            height: 25px;
            margin-left: 15px;
        }

        #pager a:hover {
            color: #EFEFEF;
            background-color: #3B71CA;
        }

        .active a {
            color: #EFEFEF !important;
            background-color: #3B71CA !important;
        }

        #pager a {
            display: inline-block;
            position: relative;
            z-index: 1;
            padding: 1em;
            margin: -1em;
            text-decoration: none;
            color: black;
            font-weight: bolder;
        }
    </style>
</head>

<body>
    <navbar class="navbar navbar-expand-lg bg-light mb-2">
        <ul class="text-light col-1 navbar-nav me-auto mb-1 mb-lg-0">
            <li class="nav-item">
                <a href="<?php echo base_url('/') ?>" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Sobre</a>
            </li>
        </ul>
        <form class="col-3 offset-3 d-flex" role="search">
            <input class="form-control ms-2 me-1" type="search" name="search" placeholder="Pesquisar" aria-label="Search">
            <input type="submit" value="&#128270;" class="btn btn-outline-primary">
        </form>
        <div class="col-1 collapse navbar-collapse justify-content-end" id="navbarNavDarkDropdown">
            <div class="btn-group dropstart">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    &#9965;
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">&#129485; Minha Conta</a></li>
                    <li><a class="dropdown-item" href="#"><strong>&#8998;</strong> Logout</a></li>
                </ul>
            </div>
        </div>
    </navbar>

    <?= $this->renderSection('conteudo') ?>

    <footer class="container-fluid text-center">
        <div>
            &copy; <?php echo date('Y') ?>
        </div>
    </footer>

    <script src="<?= base_url('assets/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap.min.js') ?>"></script>

    <?= $this->renderSection("script"); ?>
</body>

</html>