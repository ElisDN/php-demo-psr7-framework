<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/default'); ?>

<?php $this->beginBlock('content') ?>
    <div class="row">
        <div class="col-md-9">
            <?= $this->renderBlock('main') ?>
        </div>
        <div class="col-md-3">
            <?= $this->renderBlock('sidebar') ?>
        </div>
    </div>
<?php $this->endBlock() ?>