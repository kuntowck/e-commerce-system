<!DOCTYPE html>
<html>

<head>
    <title>Create Order</title>
</head>

<body>
    <h1>Create Order</h1>
    <form action="/pesanan/create" method="post">
        <label for="status">Status:</label>
        <input type="text" name="status" required><br>
        <button type="submit">Create</button>
    </form>
    <a href="/pesanan">Back to Order List</a>
</body>

</html>