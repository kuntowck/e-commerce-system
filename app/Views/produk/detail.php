<!DOCTYPE html>
<html>

<head>
    <title>Product Detail</title>
</head>

<body>
    <h1>Product Detail</h1>

    <p><?= $product->getId() ?></p>
    <p><?= $product->getNama() ?></p>
    <p><?= $product->getHarga() ?></p>
    <p><?= $product->getKategori() ?></p>
    <p><?= $product->getStok() ?></p>
    <a href="/mahasiswa">Kembali ke Product Catalog</a>
</body>

</html>