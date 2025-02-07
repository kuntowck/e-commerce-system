<!DOCTYPE html>
<html>

<head>
    <title>Product Catalog</title>
</head>

<body>
    <h1>Product Catalog</h1>
    <a href="/produk/create">Tambah Product</a>
    <a href="/pesanan">Pesanan</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product->getId() ?></td>
                <td><?= $product->getNama() ?></td>
                <td><?= $product->getHarga() ?></td>
                <td><?= $product->getKategori() ?></td>
                <td><?= $product->getStok() ?></td>
                <td>
                    <a href="/produk/detail/<?= $product->getId() ?>">Detail< /a>
                    <a href="/produk/edit/<?= $product->getId() ?>">Edit</a>
                    <a href="/produk/delete/<?= $product->getId() ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>