<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?> Page</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <script src="<?= base_url('assets/js/pristine.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="flex flex-col bg-gray-50">
    <header class="mb-4">
        <?= $this->include('components/header'); ?>
    </header>

    <main class="container mx-auto px-4 flex flex-grow gap-4">
        <aside class="w-sm">
            <?= $this->include('components/sidebar'); ?>
        </aside>
        <section class="w-full">
            <?= $this->renderSection('content'); ?>
        </section>
    </main>

    <footer class="bg-white rounded-lg shadow-sm m-4">
        <?= $this->include('components/footer'); ?>
    </footer>

    <?= $this->renderSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js">
    </script>
</body>

</html>