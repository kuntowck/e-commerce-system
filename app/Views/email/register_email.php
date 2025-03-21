<?= $this->extend('layouts/email_layout'); ?>

<?= $this->section('title'); ?>
<h3>This is activation email for your account on <?= site_url() ?>.</h3>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <strong>To activate your account use this URL.</strong>
    </div>
    <div class="card-body">
        <p><a href="<?= url_to('activate-account') . '?token=' . $hash ?>">Activate account</a>.</p>

        <br>

        <p>If you did not registered on this website, you can safely ignore this email.</p>
    </div>
</div>
<?= $this->endSection(); ?>