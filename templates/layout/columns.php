<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 */
?>

<?php $this->extend('layout/default'); ?>

<?php $this->beginBlock('content') ?>
    <div class="row">
        <div class="col-md-9">
            <?= $this->renderBlock('main') ?>
        </div>
        <div class="col-md-3">
            <?php $this->block('sidebar', function () { ob_start(); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Site</div>
                    <div class="panel-body">
                        Site navigation
                    </div>
                </div>
            <?php return ob_get_clean(); }); ?>
            <?= $this->renderBlock('sidebar') ?>
        </div>
    </div>
<?php $this->endBlock() ?>