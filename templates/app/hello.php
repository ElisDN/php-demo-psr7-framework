<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/default'); ?>

<?php $this->beginBlock('title') ?>Hello<?php $this->endBlock() ?>

<?php $this->beginBlock('meta'); ?>
    <meta name="description" content="Home Page description" />
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content') ?>
    <div class="jumbotron">
        <h1>Hello!</h1>
        <p>
            Congratulations! You have successfully created your application.
        </p>
    </div>
<?php $this->endBlock() ?>
