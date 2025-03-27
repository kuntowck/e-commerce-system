<nav class="bg-white border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <?php if (!empty(user_id())): ?>
            <?php foreach (user()->getRoles() as $role): ?>
                <a href="<?= base_url('/' . $role . '/dashboard'); ?>" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <!-- <img src="" class="h-8" alt="Logo" /> -->
                    <span class="self-center text-2xl text-blue-700 font-semibold whitespace-nowrap">E-Commerce</span>
                </a>
                <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                    <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white">
                        <li>
                            <a href="<?= base_url('/' . $role . '/dashboard'); ?>" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 ">Dashboard</a>
                        </li>

                        <?php if (in_groups('product-manager')): ?>
                            <li>
                                <a href="<?= base_url('/' . $role . '/products'); ?>" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 ">Products</a>
                            </li>

                            <li>
                                <a href="<?= base_url('/' . $role . '/products/report'); ?>" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 ">Reports</a>
                            </li>
                        <?php endif; ?>

                        <?php if (in_groups('customer') || in_groups('admin')): ?>
                            <li>
                                <a href="<?= base_url('/customer/catalog'); ?>" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 ">Catalog</a>
                            </li>
                            <li>
                                <a href="<?= base_url('/customer/profile/' . user_id()); ?>" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 ">Profile</a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <?php if (logged_in()): ?>
                                <a href="/logout" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 ">Logout</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <a href="<?= base_url('/'); ?>" class="flex items-center space-x-3 rtl:space-x-reverse">
                <!-- <img src="" class="h-8" alt="Logo" /> -->
                <span class="self-center text-2xl font-semibold whitespace-nowrap">E-Commerce</span>
            </a>

            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white">
                    <a href="/login" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 ">Login</a>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>