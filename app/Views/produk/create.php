<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
</head>

<body>
    <h1>Add Product</h1>
    <form action="/produk" method="post">
        <label for="id">Id:</label>
        <input type="text" name="id" required><br>
        <label for="nama">Name:</label>
        <input type="text" name="nama" required><br>
        <label for="harga">Price:</label>
        <input type="number" name="harga" required><br>
        <label for="kategori">Category:</label>
        <input type="text" name="kategori" required><br>
        <label for="stok">Stock:</label>
        <input type="number" name="stok" required><br>
        <button type="submit">Add</button>
    </form>
    <a href="/produk">Back to Catalog</a>
</body>

</html>