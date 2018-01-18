<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 * @var string $name
 */
?>

<?php $this->extend('layout/columns'); ?>

<?php $this->beginBlock('title') ?>Cabinet<?php $this->endBlock() ?>

<?php $this->beginBlock('breadcrumbs') ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Cabinet</li>
    </ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('main') ?>
    <h1>Cabinet of <?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE) ?></h1>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('sidebar') ?>
    <div class="panel panel-default">
        <div class="panel-heading">Cabinet</div>
        <div class="panel-body">
            Cabinet navigation
        </div>
    </div>
<?php $this->endBlock(); ?>