<!DOCTYPE html>
<html>

<head>
    <title>Product Catalog</title>
</head>

<body>
    <h1>Product Catalog</h1>
    <a href="/produk/new">Tambah Product</a>
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
                    <a href="/produk/<?= $product->getId() ?>">Detail</a>
                    <a href="/produk/<?= $product->getId() ?>/edit">Edit</a>
                    <form action="/produk/<?= $product->getId() ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" onclick="return confirm('Are you sure?')">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>