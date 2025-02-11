<!DOCTYPE html>
<html>

<head>
    <title>Order Detail</title>
</head>

<body>
    <h1>Order Detail</h1>
    <?php foreach ($order->getProduk() as $produk) : ?>
        <p>ID: <?= $order->getId() ?></p>
        <p>Produk: <?= $produk->nama ?></p>
        <p>harga: <?= $produk->harga ?></p>
        <p>Kuantitas: <?= $order->getKuantitas() ?></p>
        <p>Total: <?= $produk->harga * $order->getKuantitas() ?></p>
        <p>Status: <?= $order->getStatus() ?></p>
    <?php endforeach; ?>
    <a href="/pesanan">Back to Order List</a>
</body>

</html>