<?php if (in_groups('admin')): ?>
    <div class="bg-white p-4 rounded-lg shadow-sm">
        <ul class="space-y-2">
            <li><a href="<?= base_url('/admin/dashboard'); ?>" class="block py-2 px-3 font-medium text-gray-500 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:bg-gray-200">Dashboard</a></li>
            <li><a href="<?= base_url('/admin/users'); ?>" class="block py-2 px-3 font-medium text-gray-500 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:bg-gray-200">Users</a></li>
            <li><a href="<?= base_url('/admin/roles'); ?>" class="block py-2 px-3 font-medium text-gray-500 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:bg-gray-200">Roles</a></li>
            <li><a href="<?= base_url('/product-manager/products'); ?>" class="block py-2 px-3 font-medium text-gray-500 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:bg-gray-200">Products</a></li>
            <li><a href="<?= base_url('/admin/users/report'); ?>" class="block py-2 px-3 font-medium text-gray-500 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:bg-gray-200">Reports</a></li>
        </ul>
    </div>
<?php endif; ?>