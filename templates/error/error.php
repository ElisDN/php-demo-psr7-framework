<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */

$this->extend('layout/default');
?>

<?php $this->beginBlock('title'); ?>500 - Server error<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs'); ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Error</li>
    </ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content'); ?>
    <h1>500 - Server error</h1>
<?php $this->endBlock(); ?>