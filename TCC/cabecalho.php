<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ServiçoZ</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap.min.css" rel="stylesheet">
    


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .font-1 {
            color: #000 !important;
            font-weight: bolder;
        }

        .bg-primary {
            background-color: #007bff !important;
            /* Cor azul personalizada */
            color: white;
            /*  cor do texto*/
        }

        .sidebar .nav-link {
            color: white !important;
            /* cor para os links dentro do sidebar */
        }

        .sidebar .nav-link.active {
            font-weight: bold;
            color: #ffffff !important;
            /* Cor para o link ativo */
        }

        #sidebarMenu {
            background-color: #66ccff !important;
            /* Azul mais claro */
            color: white;
            /* Ajusta a cor do texto, se necessário */
        }

        .navbar-text .fs-4 {
            color: black;
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="dist/dashboard.css" rel="stylesheet">


</head>

<body>

    <?php

    if (!function_exists("autenticado")) {
        ?>
        <br>
        <h1>Atencao!!! Voce esqueceu o require do arquivo <br><strong><code>logica-autenticacao.php</code></strong></h1>
        <?php
        die();
    }
    ?>

    <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">
            ServicoZ
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExample03">
            <ul class="navbar-nav mr-auto px-3 pb-2">
                <li class="nav-item">
                    <a class="nav-link btn btn-light btn-sm btn-block font-1 my-1" href="form-login.php">Entrar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-danger btn-sm btn-block font-1 my-1" href="sair.php">Sair</a>
                </li>
            </ul>
        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start pe-3 d-none d-sm-block">
            <div class="text-end">
                <?php
                if (!autenticado()) {
                    ?>
                        <a href="formulario-usuarios.php" class="btn btn-light me-2">
                            Cadastrar
                            <span data-feather="user-plus"></span>
                        </a>
                        <a href="form-login.php" class="btn btn-success">
                            Entrar
                            <span data-feather="log-in"></span>
                        </a>
                    <?php
                } else {
                    //Esta autenticado
                    ?>

                    <!--Esta autenticado mas n é profissional-->
                    <?php
                        if (!isProfissional()) {
                            ?>
                                <a href="cadastro-profissional.php" class="btn btn-warning me-4" style="background-color: #ff9800;">
                                    <span data-feather="user-plus"></span>
                                    Divulgue seu serviço
                                </a>
                            <?php
                        }
                    ?>

                    <span class="navbar-text">
                        <span data-feather="user"></span>
                        
                        <?php
                        if(isAdmin()){
                        ?>
                            <span class="fs-4 mx-2 fw-bold text-warning">
                                #<?= nome_usuario(); ?>
                            </span>
                        <?php

                        } else {
                        ?>
                            <span class="fs-4 mx-2 fw-bold ">
                                <?= nome_usuario(); ?>
                            </span>
                        <?php
                        }
                        ?>

                    </span>

                    <a href="sair.php" class="btn btn-danger me-2">
                        Sair
                        <span data-feather="log-out"></span>
                    </a>

                    <?php
                }
                ?>

            </div>
        </div>

    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-primary sidebar collapse">
                <div class="position-sticky mt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">
                                <span data-feather="home"></span>
                                Início
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="listagem-servicos-cards.php">
                                <i data-feather="briefcase"></i>
                                Serviços
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="listagem-profissionais.php">
                                <span data-feather="user"></span>
                                Profissionais
                            </a>
                        </li>

                        <?php
                        if(!autenticado()){ 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="formulario-usuarios.php">
                                <span data-feather="plus"></span>
                                Ofereça seus serviços
                            </a>
                        </li>
                        <?php
                        }
                        ?>
    

                        
                        <?php
                        if(isProfissional()){
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="meus-servicos.php">
                                    <span data-feather="clipboard"></span>
                                    Meus Serviços
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <?php
                        if(autenticado()){ 
                        ?>

                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="perfil-geral.php?email=<?= urlencode($_SESSION["email"])?>">
                                    <span data-feather="user"></span>
                                    Meu Perfil
                                </a>
                            </li>

                             <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="listagem-usuarios.php">
                                    <span data-feather="users"></span>
                                    Usuarios
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $titulo_pagina ?></h1>
                </div>
                <br>