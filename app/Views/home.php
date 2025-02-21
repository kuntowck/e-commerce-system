<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/public_layout'); ?>

<?= $this->section('content'); ?>
<div class="max-w-screen-xl mx-auto p-4">
    <h1 class="text-xl font-bold mb-6">Welcome to Online Food Ordering System</h1>

</div>
<?= $this->endSection(); ?>