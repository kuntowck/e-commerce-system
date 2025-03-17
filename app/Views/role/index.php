<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="bg-white shadow-sm rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-4"><?= $title; ?></h1>

    <div class="mb-4">
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="bg-green-100 text-green-800 text-sm font-medium me-2 px-4 py-2 rounded-sm">
                <?= session()->getFlashdata('message'); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="bg-red-100 text-red-800 text-sm font-medium me-2 px-4 py-2 rounded-sm">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <a href="<?= base_url('admin/roles/new'); ?>" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Create
        </a>
    </div>
    <div class="overflow-x-auto mt-6">
        <table class="w-full divide-y divide-gray-200 mb-6">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $count = 1; ?>
                <?php foreach ($roles as $role): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= $count++; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= view_cell('BadgeCell', ['text' => $role->name]); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= $role->description ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="<?= base_url('admin/roles/update/' . $role->id) ?>" class="inline-block px-4 py-2 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                Update
                            </a>
                            <form action="<?= base_url('admin/roles/delete/' . $role->id) ?>" method="post" class="inline-block">
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
    </div>
</div>
<?= $this->endSection(); ?>