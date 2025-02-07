<!DOCTYPE html>
<html>

<head>
    <title>Update Order Status</title>
</head>

<body>
    <h1>Update Order Status</h1>
    <form action="/pesanan/update_status" method="post">
        <label for="status">Status:</label>
        <input type="text" name="status" value="<?= $order->getStatus() ?>" required><br>
        <button type="submit">Update</button>
    </form>
    <a href="/pesanan">Back to Order List</a>
</body>

</html>