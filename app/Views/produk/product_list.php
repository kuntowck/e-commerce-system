<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/public_layout'); ?>

<?= $this->section('content'); ?>
<?= $content; ?>
<?= $this->endSection(); ?>