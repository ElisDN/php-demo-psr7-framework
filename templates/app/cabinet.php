<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 * @var string $name
 */
?>

<?php $this->extend('layout/columns'); ?>

<?php $this->params['title'] = 'Cabinet'; ?>

<ul class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li class="active">Cabinet</li>
</ul>

<h1>Cabinet of <?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE) ?></h1>