<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */

$this->extend('layout/default');
?>

<?php $this->beginBlock('title'); ?>404 - Not found<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs'); ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Error</li>
    </ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content'); ?>
    <h1>404 - Not Found</h1>
<?php $this->endBlock(); ?>