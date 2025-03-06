<?= $this->section('title'); ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="max-w-screen-xl mx-auto p-4 mb-8">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">User List</h1>
        <form action="<?= $baseURL; ?>" method="get" class="mb-6">

            <div class="flex-wrap items-center gap-4">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input name="search" type="search" id="default-search" value="<?= $params->search; ?>" class="block w-full p-4 ps-10 text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Search user..." />
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-4 py-2">Search</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                <div class="">
                    <select name="role" class="form-select mt-1 block w-full px-3 py-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role; ?>" <?= ($params->role === $role) ? 'selected' : '' ?>>
                                <?= ucfirst($role) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="">
                    <select name="status" class="form-select mt-1 block w-full px-3 py-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?= $status; ?>" <?= ($params->status === $status) ? 'selected' : '' ?>>
                                <?= ucfirst($status) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="">
                    <select name="perPage" class="form-select mt-1 block w-full px-3 py-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="this.form.submit()">
                        <option value="2" <?= $params->perPage === 2 ? 'selected' : ''; ?>>2 Halaman</option>
                        <option value="4" <?= $params->perPage === 4 ? 'selected' : ''; ?>>4 Halaman</option>
                    </select>
                </div>

                <div class="place-self-center">
                    <a href="<?= $params->getResetUrl($baseURL); ?>" class="w-full px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Reset</a>
                </div>
            </div>

            <input type="hidden" name="sort" value="<?= $params->sort; ?>">
            <input type="hidden" name="order" value="<?= $params->order; ?>">
        </form>
        <div>
            <a href="/admin/user/new" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Create
            </a>
        </div>
        <div class="overflow-x-auto mt-6">
            <table class="w-full divide-y divide-gray-200 mb-6">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="<?= $params->getSortUrl('id', $baseURL) ?>">
                                ID <?= $params->isSortedBy('id') ? ($params->getSortDirection() == 'asc' ?
                                        '↑' : '↓') : '' ?>
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="<?= $params->getSortUrl('username', $baseURL) ?>">
                                Username <?= $params->isSortedBy('username') ? ($params->getSortDirection() == 'asc' ?
                                                '↑' : '↓') : '' ?>
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="<?= $params->getSortUrl('email', $baseURL) ?>">
                                Email <?= $params->isSortedBy('email') ? ($params->getSortDirection() == 'asc' ?
                                            '↑' : '↓') : '' ?>
                            </a>

                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="<?= $params->getSortUrl('last_login', $baseURL) ?>">
                                Last Login <?= $params->isSortedBy('last_login') ? ($params->getSortDirection() == 'asc' ?
                                            '↑' : '↓') : '' ?>
                            </a>

                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= $user->id ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= $user->full_name ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= $user->username ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= $user->email ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= $user->role ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= $user->status_cell ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= $user->timesAgo() ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="/user/profile/<?= $user->id ?>" class="inline-block px-4 py-2 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                    Detail
                                </a>
                                <a href="/admin/user/update/<?= $user->id ?>" class="inline-block px-4 py-2 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                    Update
                                </a>
                                <form action="/admin/user/delete/<?= $user->id ?>" method="post" class="inline-block">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="inline-block px-2 py-2 text-xs font-medium text-white focus:outline-none bg-red-500 rounded-md border border-red-200 hover:bg-red-700 hover:text-gray-200 focus:z-10 focus:ring-4 focus:ring-red-100 cursor-pointer">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-center mb-4">
                <?= $pager->links('users', 'custom_pager'); ?>
            </div>

            <div class="text-center">
                <small>
                    Showing <?= count($users) ?> from <?= $total ?> total data (Page <?= $params->page ?>)
                </small>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>