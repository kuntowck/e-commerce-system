<!DOCTYPE html>
<html>

<head>
    <title>Order List</title>
</head>

<body>
    <h1>Order List</h1>
    <a href="/pesanan/create">Create New Order</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Produk</th>
            <th>Total</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>

                <td><?= $order->getId() ?></td>
                <?php foreach ($order->getProduk() as $produk): ?>
                    <td><?= $produk->nama ?> | Rp<?= $produk->harga ?></td><br>
                    <td>Rp<?= $produk->harga * $order->getKuantitas() ?></td>
                <?php endforeach; ?>
                <td><?= $order->getStatus() ?></td>
                <td>
                    <a href="/pesanan/detail/<?= $order->getId() ?>">Detail</a>
                    <a href="/pesanan/update/<?= $order->getId() ?>">Update Status</a>
                    <a href="/pesanan/delete/<?= $order->getId() ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>