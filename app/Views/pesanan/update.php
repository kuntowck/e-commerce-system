<!DOCTYPE html>
<html>

<head>
    <title>Update Order Status</title>
</head>

<body>
    <h1>Update Order Status</h1>
    <form action="/pesanan/update/" method="post">
        <input type="text" name="status" value="<?= $order->getId() ?>" readonly><br>
        <?php foreach ($order->getProduk() as $produk) : ?>
            <input type="text" name="status" value="<?= $produk->nama ?>" readonly><br>
            <input type="text" name="status" value="<?= $produk->harga ?>" readonly><br>
        <?php endforeach; ?>
        <input type="text" name="status" value="<?= $produk->harga * $order->getKuantitas() ?>" readonly><br>
        <label for="status">Status:</label>
        <input id="status" type="text" name="status" value="<?= $order->getStatus() ?>" required><br>
        <input type="text" name="status" value="<?= $order->getKuantitas() ?>" readonly><br>
        <button type="submit">Update</button>
    </form>
    <a href="/pesanan">Back to Order List</a>
</body>

</html>