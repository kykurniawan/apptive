<?php
defined('APP') or exit('Access denied');
?>

<nav class="navbar navbar-expand-lg bg-light border-bottom">
    <div class="container">
        <a class="navbar-brand" href="<?= url('home') ?>"><?= config('app_name') ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="<?= url('home') ?>">Home</a>
                <a class="nav-link active" aria-current="page" href="<?= url('about') ?>">About</a>
            </div>
        </div>
    </div>
</nav>