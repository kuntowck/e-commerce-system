<!DOCTYPE html>
<html>
head>
<title>Order Detail</title>
</head>

<body>
    <h1>Order Detail</h1>
    <p>ID: <?= $order->getId() ?></p>
    <p>Kategori: <?= $order->getKategori() ?></p>
    <p>Total: <?= $order->getTotal() ?></p>
    <p>Status: <?= $order->getStatus() ?></p>
    <a href="/pesanan">Back to Order List</a>
</body>

</html>