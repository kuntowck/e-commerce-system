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
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($pesanan as $order): ?>
            <tr>
                <td><?= $order->getId() ?></td>
                <td><?= $order->getStatus() ?></td>
                <td>
                    <a href="/pesanan/detail/<?= $order->getId() ?>">Detail</a>
                    <a href="/pesanan/update_status/<?= $order->getId() ?>">Update Status</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>