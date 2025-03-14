<?php if (in_groups('admin')): ?>
    <div class="bg-white p-4 rounded-lg shadow-sm">
        <ul class="space-y-2">
            <li><a href="<?= base_url('/admin/dashboard'); ?>" class="block py-2 px-3 font-medium text-gray-900 rounded hover:bg-gray-100 focus:bg-gray-200 hover:text-blue-700">Dashboard</a></li>
            <li><a href="<?= base_url('/admin/users'); ?>" class="block py-2 px-3 font-medium text-gray-900 rounded hover:bg-gray-100 focus:bg-gray-200 hover:text-blue-700">Users</a></li>
            <li><a href="<?= base_url('/product-manager/products'); ?>" class="block py-2 px-3 font-medium text-gray-900 rounded hover:bg-gray-100 focus:bg-gray-200 hover:text-blue-700">Products</a></li>
            <li><a href="<?= base_url('/product-manager/orders'); ?>" class="block py-2 px-3 font-medium text-gray-900 rounded hover:bg-gray-100 focus:bg-gray-200 hover:text-blue-700">Orders</a></li>
        </ul>
    </div>
<?php endif; ?>