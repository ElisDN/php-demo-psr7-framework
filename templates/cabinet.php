<?php
/** @var string $name */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Cabinet - App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <style>
        body { padding-top: 70px; }
        .app { display: flex; min-height: 100vh; flex-direction: column; }
        .app-content { flex: 1; }
        .app-footer { padding-bottom: 1em; }
    </style>
</head>
<body class="app">
<header class="app-header">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    Application
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/about"><i class="glyphicon glyphicon-book"></i> About</a></li>
                    <li><a href="/cabinet"><i class="glyphicon glyphicon-user"></i> Cabinet</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="app-content">
    <main class="container">

        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Cabinet</li>
        </ul>

        <h1>Cabinet of <?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE) ?></h1>

    </main>
</div>

<footer class="app-footer">
    <div class="container">
        <hr />
        <p>&copy; 2017 - My App.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
