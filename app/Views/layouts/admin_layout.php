<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="flex flex-col min-h-screen bg-gray-50">
    <?= $this->include('components/header'); ?>

    <main class="flex flex-grow container mx-auto p-4">
        <aside class="w-1/4 p-4">
            <?= $this->include('components/sidebar'); ?>
        </aside>
        <section class="w-3/4 p-4">
            <?= $this->renderSection('content'); ?>
        </section>
    </main>

    <?= $this->include('components/footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js">
    </script>
</body>

</html>