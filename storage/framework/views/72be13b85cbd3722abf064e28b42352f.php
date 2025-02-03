

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
            <div class="flex justify-between items-center w-full mb-4">
                <h1 class="text-3xl font-semibold text-gray-800 dark:text-white"><?php echo e($file->file_name); ?></h1>
                <a href="<?php echo e(route('folders.index', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash])); ?>" class="text-blue-500 hover:text-blue-400">Voltar para a pasta</a>
            </div>

            <?php if(isset($fileUrl)): ?>
                <div class="flex justify-center items-center mb-6">
                    <img src="<?php echo e($fileUrl); ?>" alt="Imagem" style="max-height: 500px;"/>
                </div>
            <?php elseif(isset($filePath)): ?>
                <div class="flex justify-center items-center mb-6">
                    <embed src="<?php echo e(asset('storage/' . $file->file_path)); ?>" type="application/pdf" width="80%" height="600px"/>
                </div>
            <?php elseif(isset($fileContent)): ?>
                <div class="flex justify-center items-center mb-6">
                    <pre class="text-gray-800 dark:text-white whitespace-pre-wrap"><?php echo e($fileContent); ?></pre>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/files/show.blade.php ENDPATH**/ ?>