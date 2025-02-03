

<?php $__env->startSection('content'); ?>
    <div class="relative bg-cover bg-center min-h-screen flex flex-col justify-center items-center text-center text-white" style="background-image: url('<?php echo e(asset('img/background.jpg')); ?>');">
        <div class="bg-black bg-opacity-50 p-10 rounded-lg shadow-lg max-w-2xl">
            <h1 class="text-4xl font-bold mb-4">Bem-vindo ao QualiaTTRPG</h1>
            <p class="text-lg text-gray-300 mb-6">Uma plataforma para você criar e gerenciar suas aventuras de RPG de forma flexível e dinâmica.</p>
            <div class="space-x-4">
                <a href="<?php echo e(route('register')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md shadow-md transition duration-300">
                    Criar Conta
                </a>
                <a href="<?php echo e(route('login')); ?>" class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-3 rounded-md shadow-md transition duration-300">
                    Entrar
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/home.blade.php ENDPATH**/ ?>