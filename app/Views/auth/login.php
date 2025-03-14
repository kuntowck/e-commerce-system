<?= $this->extend('layouts/auth_layout') ?>
<?= $this->section('content') ?>

<div class="w-full bg-white rounded-lg shadow">
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
            Sign in to your account
        </h1>

        <?php if (session('error') !== null): ?>
            <div class="bg-red-100 text-red-800 text-sm font-medium mt-2 me-2 px-4 py-2 rounded-sm">
                <?= session('error') ?? ''; ?>
            </div>
        <?php elseif (session('message') !== null): ?>
            <div class="bg-green-100 text-green-800 text-sm font-medium mt-2 me-2 px-4 py-2 rounded-sm">
                <?= session('message') ?? ''; ?>
            </div>
        <?php endif; ?>


        <form class="space-y-4 md:space-y-6" action="<?= route_to('login'); ?>" method="post">
            <?= csrf_field(); ?>

            <div>
                <label for="login" class="block mb-2 text-sm font-medium text-gray-900">Your email or username</label>
                <input
                    type="text"
                    name="login"
                    id="login"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 <?= session('errors.login') ? 'is_invalid' : '' ?>"
                    placeholder="Email or username"
                    value="<?= old('login'); ?>">

                <?php if (session('errors.login')): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <?= session('errors.login'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 <?= session('errros.password'); ?>">

                <?php if (session('errors.password')): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <?= session('errors.password'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($config->allowRemembering): ?>
                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input
                                id="remember"
                                name="remember"
                                aria-describedby="remember"
                                type="checkbox"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 <?php old('remember') ? 'checked' : '' ?>">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500">
                                <?= lang('Auth.rememberMe') ?>
                            </label>
                        </div>
                    </div>
                    <?php if ($config->activeResetter): ?>
                        <a href="<?= route_to('forgot'); ?>" class="text-sm font-medium text-blue-600 hover:underline">
                            <?= lang('Auth.forgotYourPassword') ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer">Sign in</button>
            <p class="text-sm font-light text-gray-500">
                Don’t have an account yet? <a href="/register" class="font-medium text-blue-600 hover:underline">Sign up</a>
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