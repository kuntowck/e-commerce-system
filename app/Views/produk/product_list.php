<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?php if (in_groups('admin')): ?>
    <?= $this->extend('layouts/admin_layout'); ?>
<?php else: ?>
    <?= $this->extend('layouts/public_layout'); ?>
<?php endif; ?>

<?= $this->section('content'); ?>
<div class="bg-white shadow-sm rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-4"><?= $title; ?></h1>
    <div class="mb-4">
        <form action="<?= $baseURL; ?>" method="get">
            <div class="mb-4">
                <div class="flex-wrap items-center gap-4">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input name="search" type="search" id="default-search" value="<?= $params->search; ?>" class="block w-full p-4 ps-10 text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Search product..." />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-4 py-2 cursor-pointer">Search</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                    <div>
                        <select name="category_id" class="form-select mt-1 block w-full px-3 py-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="this.form.submit()">
                            <option value="">All Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id; ?>" <?= ($params->category_id === $category->id) ? 'selected' : '' ?>>
                                    <?= ucfirst($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <select name="price_range" class="form-select mt-1 block w-full px-3 py-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="this.form.submit()">
                            <option value="">All Price</option>
                            <?php foreach ($priceRange as $price): ?>
                                <option value="<?= $price['value']; ?>" <?= ($params->price_range == $price['value']) ? 'selected' : '' ?>>
                                    <?= $price['label']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <select name="sort" class="form-select mt-1 block w-full px-3 py-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="this.form.submit()">
                            <option value="2" <?= $params->perPage === 2 ? 'selected' : ''; ?>>2 Halaman</option>
                            <option value="4" <?= $params->perPage === 4 ? 'selected' : ''; ?>>4 Halaman</option>
                        </select>
                    </div>

                    <div class="mt-1 block w-full flex justify-stretch border divide-x divide-gray-300 text-sm border border-gray-300 rounded-md shadow-sm">
                        <a
                            href="<?= $params->getSortUrl('name', $baseURL) ?>"
                            class="w-full flex py-4 item-center justify-center hover:bg-blue-100 hover:text-blue-700 focus:outline-none">
                            Name <?= $params->isSortedBy('name') ? ($params->getSortDirection() == 'asc' ?
                                        '↑' : '↓') : '' ?>
                        </a>
                        <a
                            href="<?= $params->getSortUrl('price', $baseURL) ?>"
                            class="w-full flex py-4 item-center justify-center hover:bg-blue-100 hover:text-blue-700 focus:outline-none">
                            Price <?= $params->isSortedBy('price') ? ($params->getSortDirection() == 'asc' ?
                                        '↑' : '↓') : '' ?>
                        </a>
                        <a
                            href="<?= $params->getSortUrl('created_at', $baseURL) ?>"
                            class="w-full flex py-4 item-center justify-center hover:bg-blue-100 hover:text-blue-700 focus:outline-none">
                            Created At <?= $params->isSortedBy('created_at') ? ($params->getSortDirection() == 'asc' ?
                                            '↑' : '↓') : '' ?>
                        </a>
                    </div>

                    <div class="place-self-start">
                        <a href="<?= $params->getResetUrl($baseURL); ?>" class="w-full px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Reset</a>
                    </div>
                </div>

                <input type="hidden" name="sort" value="<?= $params->sort; ?>">
                <input type="hidden" name="order" value="<?= $params->order; ?>">
        </form>
    </div>

    <div class="mb-4">
        <?= $content; ?>
    </div>

    <div class="mb-4 text-center">
        <?= $pager->links('products', 'custom_pager'); ?>
    </div>

    <div class="mb-4 text-center">
        <small>
            Showing <?= $countData; ?> of <?= $total ?> total data | Page <?= $params->page ?>
        </small>
    </div>
</div>
<?= $this->endSection(); ?>