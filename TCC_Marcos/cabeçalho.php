<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Serviçoz</title>

    <!-- Bootstrap core CSS -->
    <link href="css/styles.css" rel="stylesheet" />
    

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

        #layoutSidenav {
            height: 100vh; /* 100% da altura da viewport */
            display: flex; /* Usar flexbox para organizar o layout */
        }
        
        main {
            flex-grow: 1; /* Permitir que o main ocupe o espaço restante */
            padding: 20px; /* Espaçamento interno */
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="dist/dashboard.css" rel="stylesheet">


</head>

<body>

    <?php   
    if(!function_exists("autenticado")){
    ?>
        <br>
        <h1>Atencao!!! Voce esqueceu o require do arquivo <br><strong><code>logica-autenticacao.php</code></strong></h1>
    <?php
        die();
    }
    ?>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">
            Serviçoz
        </a>
        

        <div class="navbar-collapse collapse" id="navbarsExample03">
            <ul class="navbar-nav mr-auto px-3 pb-2">
                <li class="nav-item">
                    <a class="nav-link" href="inicio.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Servicos.php">Cadastro de Servicos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Busca_prestadores.php">Busca Profisionais</a>
                </li>
                
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
                if(!autenticado()){
                ?>
                    <a href="formulario-usuarios.php" class="btn btn-info me-2">
                        <span data-feather="user-plus"></span>
                        Cadastar
                    </a>
                    <a href="form-login.php" class="btn btn-success">
                        <span data-feather="log-in"></span>
                        Entrar
                    </a>

                <?php
                } else {

                    //está autenticado
                ?>
                    <span class="navbar-text">
                        <span data-feather="user"></span>
                        <?php

                        if(isAdmin()){
                        ?>
                            <span class="fs-4 mx-2 fw-bold text-danger">
                                #<?= nome_usuario(); ?>
                            </span>
                        <?php

                        } else {
                        ?>
                            <span class="fs-4 mx-2">
                                <?= nome_usuario(); ?>
                            </span>
                        <?php
                        }
                        ?>
                    </span>
                    <a href="sair.php" class="btn btn-danger me-2">
                        <span data-feather="log-out"></span>
                        Sair
                    </a>

                <?php
                }
                ?>
            </div>
        </div>

    </header>
    

    
        
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="inicio.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home-alt"></i></div>
                            Início
                        </a>
                        <a class="nav-link" href="cadastro-servicos.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Cadastro de Serviços
                        </a>
                        <a class="nav-link" href="listagem-servicos.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                            Listagem Serviços
                        </a>
                        <a class="nav-link" href="cadastro-profissionais.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                            Cadastrar Profissional
                        </a>
                        <a class="nav-link" href="listagem-profissionais.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                            Listagem Profissionais
                        </a>
                    </div>
                </div>
            </nav>
        </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?=$titulo_pagina?></h1>
                </div>
                <br>