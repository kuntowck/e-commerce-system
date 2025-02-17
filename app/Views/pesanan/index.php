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
                    <td>Rp<?= $order->getTotal() ?></td>
                <?php endforeach; ?>
                <td><?= $order->getStatus() ?></td>
                <td>
                    <a href="/pesanan/detail/<?= $order->getId() ?>">Detail</a>
                    <a href="/pesanan/update/<?= $order->getId() ?>">Update Status</a>
                    <form action="/pesanan/delete/<?= $order->getId() ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>