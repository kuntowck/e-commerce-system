<?= $this->extend('layouts/email_layout'); ?>

<?= $this->section('title'); ?>
<h3><?= $title; ?></h3>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h3><?= user()->username; ?>, has been added a new product. Please check it out.</h3>
    </div>
    <div class="card-body">
        <h4>Product Details</h4>
        <p><strong>Name:</strong> <?= $product->name; ?></p>
        <p><strong>Category:</strong> <?= $product->category_name; ?></p>
        <p><strong>Price:</strong> Rp<?= $product->price ?></p>
        <p><strong>Description:</strong> <?= $product->description; ?></p>
        <p><strong>Stock:</strong> <?= $product->stock; ?> (<?= $product->status; ?>)</p>
        <p><strong>Added by:</strong> <?= user()->username; ?></p>
        <p><strong>Added on:</strong> <?= $product->created_at; ?></p>
        <a href="<?= $link; ?>">See Product</a>
    </div>
</div>
<?= $this->endSection(); ?>