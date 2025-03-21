<?= $this->extend('layouts/auth_layout') ?>
<?= $this->section('content') ?>

<div class="w-full bg-white rounded-lg shadow">
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
            Create an account
        </h1>

        <div class="mb-4">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="bg-red-100 text-red-800 text-sm font-medium me-2 px-4 py-2 rounded-sm">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>
        </div>

        <form class="space-y-4 md:space-y-6" action="<?= route_to('register') ?>" method="post">
            <?= csrf_field(); ?>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">

                <?php if (session('errors.email')): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <?= session('errors.email'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Your username</label>
                <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">

                <?php if (session('errors.username')): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <?= session('errors.username'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900">Your Name</label>
                <input type="text" name="full_name" id="full_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="Full Name" value="<?= old('full_name') ?>">

                <?php if (session('errors.full_name')): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <?= session('errors.full_name'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">

                <?php if (session('errors.password')): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <?= session('errors.password'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <label for="pass_confirm" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
                <input type="password" name="pass_confirm" id="pass_confirm" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">

                <?php if (session('errors.pass_confirm')): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <?= session('errors.pass_confirm'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer">Create an account</button>
            <p class="text-sm font-light text-gray-500">
                Already have an account? <a href="/login" class="font-medium text-blue-600 hover:underline">Login here</a>
            </p>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
<script>
    let pristine;
    window.onload = function() {
        let form = document.getElementById("formData");

        var pristine = new Pristine(form, {
            classTo: 'form-element',
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorTextParent: 'form-element',
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
<?= $this->endSection() ?>