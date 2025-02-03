

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-6">Criar RPG</h1>

        <form action="<?php echo e(route('rpg.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <label for="rpg_name" class="block text-white">Nome do RPG</label>
                <input type="text" id="rpg_name" name="rpg_name" class="w-full p-3 text-white bg-gray-800 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="rpg_description" class="block text-white">Descrição do RPG</label>
                <textarea id="rpg_description" name="rpg_description" class="w-full p-3 text-white bg-gray-800 rounded-md" rows="4"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-md">Criar RPG</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/rpg/create.blade.php ENDPATH**/ ?>