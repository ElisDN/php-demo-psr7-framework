<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/default'); ?>

<?php $this->beginBlock('title') ?>About<?php $this->endBlock() ?>

<?php $this->beginBlock('meta'); ?>
    <meta name="description" content="About Page description" />
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs') ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">About</li>
    </ul>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
    <h1>About the site</h1>
<?php $this->endBlock() ?>