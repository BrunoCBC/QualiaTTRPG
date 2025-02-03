

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start space-x-0 sm:space-x-4 mb-6">
            <img src="<?php echo e($user->profile_image ? asset('img/'.$user->profile_image) : asset('img/profile.png')); ?>" alt="Profile Image" class="w-32 h-32 rounded-full object-cover border-4 border-blue-600 mb-4 sm:mb-0" style="width: 10rem; height: 10rem">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white"><?php echo e($user->name); ?></h1>
                <p class="text-lg text-gray-700 dark:text-gray-400"><?php echo e('@' . $user->username); ?></p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Nickname:</span>
                <span class="text-lg text-gray-900 dark:text-white"><?php echo e($user->nickname); ?></span>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Email:</span>
                <span class="text-lg text-gray-900 dark:text-white"><?php echo e($user->email); ?></span>
            </div>
        </div>

        <div class="mt-8">
            <?php if($isOwnProfile): ?>
            <a href="<?php echo e(route('profile.edit', ['username' => $user->username])); ?>" class="w-full sm:w-auto inline-block bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">
                Editar Perfil
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/profile/show.blade.php ENDPATH**/ ?>