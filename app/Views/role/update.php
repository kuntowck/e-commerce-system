<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="bg-white shadow-sm rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6"><?= $title; ?></h1>
    <form id="formData" action="<?= base_url('admin/roles/update/' . $role->id); ?>" method="post" novalidate>
        <?php csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="<?= $role->name; ?>"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                data-pristine-required
                data-pristine-required-message="Name is required."
                value="<?= old('name') ?>">

            <div class="text-red-800 text-xs font-medium mt-2">
                <?= session('errors.name') ?? ''; ?>
            </div>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <input
                id="description"
                type="text"
                name="description"
                value="<?= $role->description; ?>"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                data-pristine-required
                data-pristine-required-message="description is required."
                value="<?= old('description') ?>">

            <div class="text-red-800 text-xs font-medium mt-2">
                <?= session('errors.descrption') ?? ''; ?>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer">Update</button>
            <a href="<?= base_url('admin/roles'); ?>" class="text-sm text-blue-500 hover:underline">Back to Role List</a>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    let pristine;
    window.onload = function() {
        let form = document.getElementById("formData");

        var pristine = new Pristine(form, {
            classTo: 'mb-4',
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorTextParent: 'mb-4',
            errorTextTag: 'div',
            errorTextClass: 'text-red-800 text-xs font-medium mt-2'
        });


        form.addEventListener('submit', function(e) {
            var valid = pristine.validate();
            if (!valid) {
                e.preventDefault();
            }
        });

    };
</script>
<?= $this->endSection(); ?>