<?= $this->section('title'); ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="max-w-screen-xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Update User</h1>
        <form id="formData" action="/admin/user/update/<?= $user->id; ?>" method="post" novalidate>
            <?php csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="<?= $user->id; ?>">

            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input
                    id="full_name"
                    type="text"
                    name="full_name"
                    value="<?= $user->full_name; ?>"
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
                    value="<?= $user->username; ?>"
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
                    value="<?= $user->email; ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    data-pristine-required
                    data-pristine-required-message="Email is required"
                    data-pristine-type="email"
                    data-pristine-type-message="Please provide a valid email address."
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
                    value="<?= $user->password; ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    disabled
                    data-pristine-required
                    data-pristine-required-message="Password is required."
                    data-pristine-minlength="8"
                    data-pristine-minlength-message="Password must be at least 8 characters long."
                    value="<?= old('password') ?>">

                <div class="text-red-800 text-xs font-medium mt-2">
                    <?= session('errors.password'); ?>
                </div>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="user" <?= $user->role === 'user' ? 'selected' : ''; ?>>
                        User
                    </option>
                    <option value="admin" <?= $user->role === 'admin' ? 'selected' : ''; ?>>
                        Admin
                    </option>

                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="active" <?= $user->status == 'active' ? 'selected' : '' ?>>
                        Active
                    </option>
                    <option value="inactive" <?= $user->status == 'inacitve' ? 'selected' : '' ?>>
                        Inactive
                    </option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer">Update</button>
                <a href="/admin/user" class="text-sm text-blue-500 hover:underline">Back to User List</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>