<!DOCTYPE html>
<html>

<head>
    <title>Update Order Status</title>
</head>

<body>
    <h1>Update Order Status</h1>
    <form action="/pesanan/update/" method="post">
        <input type="text" name="id" value="<?= $order->getId() ?>"><br>
        <label for="status">Status:</label>
        <input id="status" type="text" name="status" value="<?= $order->getStatus() ?>"><br>
        <input type="text" name="kuantitas" value="<?= $order->getKuantitas() ?>"><br>
        <button type="submit">Update</button>
    </form>
    <a href="/pesanan">Back to Order List</a>
</body>

</html>