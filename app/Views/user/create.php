<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="bg-white shadow-sm rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6"><?= $title; ?></h1>
    <form id="formData" action="<?= base_url('admin/users/new'); ?>" method="post" novalidate>
        <?php csrf_field() ?>

        <div class="mb-4">
            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input
                id="full_name"
                type="text"
                name="full_name"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                data-pristine-required
                data-pristine-required-message="Name is required."
                data-pristine-minlength="3"
                data-pristine-minlength-message="Name must be at least 3 characters long."
                value="<?= old('full_name') ?>">
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input
                id="username"
                type="text"
                name="username"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                data-pristine-required
                data-pristine-required-message="Username is required."
                data-pristine-minlength="3"
                data-pristine-minlength-message="Username must be at least 3 characters long."
                value="<?= old('username') ?>">

            <div class="text-red-800 text-xs font-medium mt-2">
                <?= session('errors.username') ?? ''; ?>
            </div>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                data-pristine-required
                value="<?= old('email') ?>">

            <div class="text-red-800 text-xs font-medium mt-2">
                <?= session('errors.email') ?? ''; ?>
            </div>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                data-pristine-required
                data-pristine-required-message="Password is required."
                data-pristine-minlength="8"
                data-pristine-minlength-message="Password must be at least 8 characters long."
                value="<?= old('password') ?>">

            <div class="text-red-800 text-xs font-medium mt-2">
                <?= session('errors.password'); ?>
            </div>
        </div>

        <div>
            <label for="pass_confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input
                type="password"
                id="pass_confirm"
                name="pass_confirm"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                data-pristine-required
                data-pristine-required-message="Password is required."
                data-pristine-minlength="8"
                data-pristine-minlength-message="Password must be at least 8 characters long."
                value="<?= old('pass_confirm') ?>">

            <div class="text-red-800 text-xs font-medium mt-2">
                <?= session('errors.pass_confirm'); ?>
            </div>
        </div>

        <div class="mb-4">
            <label for="group" class="block text-sm font-medium text-gray-700">group</label>
            <select name="group" id="group" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">All Roles</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role->id; ?>">
                        <?= ucfirst($role->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="active">
                    Active
                </option>
                <option value="inacitve">
                    Inactive
                </option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer">Create</button>
            <a href="<?= base_url('admin/users'); ?>" class="text-sm text-blue-500 hover:underline">Back to User List</a>
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