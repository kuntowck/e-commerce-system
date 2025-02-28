<?= $this->section('title'); ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="max-w-screen-xl mx-auto p-4 mb-8">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">User List</h1>
        <a href="/admin/user/new" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Create
        </a>
        <div class="overflow-x-auto mt-6">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                        <tr>
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
                                <a href="/user/profile/<?= $user->id ?>" class="inline-block px-4 py-2 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                    Detail
                                </a>
                                <a href="/admin/user/update/<?= $user->id ?>" class="inline-block px-4 py-2 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                    Update
                                </a>
                                <form action="/admin/user/delete/<?= $user->id ?>" method="post" class="inline-block">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="inline-block px-2 py-2 text-xs font-medium text-white focus:outline-none bg-red-500 rounded-lg border border-red-200 hover:bg-red-700 hover:text-gray-200 focus:z-10 focus:ring-4 focus:ring-red-100 cursor-pointer">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>