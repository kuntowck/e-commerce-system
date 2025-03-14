<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?php if (in_groups('admin')): ?>
    <?= $this->extend('layouts/admin_layout'); ?>
<?php else: ?>
    <?= $this->extend('layouts/public_layout'); ?>
<?php endif; ?>

<?= $this->section('content'); ?>
<?= $content; ?>
<?= $this->endSection(); ?>