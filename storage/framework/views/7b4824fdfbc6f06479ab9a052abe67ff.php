

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 shadow-md p-8" style="border-radius: 2rem; padding: 2rem;">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white"><?php echo e($folder ? $folder->folder_name : $rpg->rpg_name); ?></h1>
                <a href="<?php echo e(route('rpg.show', ['rpg_hash' => $rpg->hash])); ?>" class="text-blue-600 dark:text-blue-400 hover:underline text-lg">Voltar para o RPG</a>
            </div>

            <?php if($parentFolder): ?>
                <div class="mb-6">
                    <a href="<?php echo e(route('folders.index', ['rpg_hash' => $rpg->hash, 'folder_hash' => $parentFolder->hash])); ?>" class="text-blue-600 dark:text-blue-400 hover:underline text-lg">Voltar para a pasta anterior</a>
                </div>
            <?php endif; ?>

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Pastas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $folders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subfolder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="group bg-blue-100 dark:bg-blue-700 rounded-2xl shadow-lg p-6 hover:bg-blue-200 dark:hover:bg-blue-600 transition-all">
                            <div class="flex justify-center items-center mb-4">
                                <img src="<?php echo e($subfolder->folder_icon_path ?? '/default-folder-icon.png'); ?>" alt="Ícone da pasta" class="w-20 h-20 rounded-full">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2"><?php echo e($subfolder->folder_name); ?></h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4"><?php echo e($subfolder->folder_description ?? 'Sem descrição'); ?></p>
                            <a href="<?php echo e(route('folders.index', ['rpg_hash' => $rpg->hash, 'folder_hash' => $subfolder->hash])); ?>" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Entrar</a>
                            <div class="mt-4 flex space-x-4">
                                <a href="<?php echo e(route('folders.edit', ['rpg_hash' => $rpg->hash, 'folder_hash' => $subfolder->hash])); ?>" class="text-yellow-500 dark:text-yellow-400 hover:underline">Editar</a>
                                <form action="<?php echo e(route('folders.destroy', ['rpg_hash' => $rpg->hash, 'folder_hash' => $subfolder->hash])); ?>" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500 dark:text-red-400 hover:underline">Excluir</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-600 dark:text-gray-300">Nenhuma subpasta encontrada.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Fichas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $sheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="group bg-green-100 dark:bg-green-700 rounded-2xl shadow-lg p-6 hover:bg-green-200 dark:hover:bg-green-600 transition-all">
                            <div class="flex justify-center items-center mb-4">
                                <img src="<?php echo e($sheet->sheet_image_path ?? '/default-sheet-icon.png'); ?>" alt="Imagem da Ficha" class="w-20 h-20 rounded-full">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2"><?php echo e($sheet->sheet_name); ?></h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Nível: <?php echo e($sheet->sheet_level); ?></p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4"><?php echo e($sheet->sheet_description ?? 'Sem descrição'); ?></p>
                            <a href="<?php echo e(route('sheets.show', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'sheet_hash' => $sheet->hash])); ?>" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Ver Ficha</a>
                            <div class="mt-4 flex space-x-4">
                                <a href="<?php echo e(route('sheets.edit', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'sheet_hash' => $sheet->hash])); ?>" class="text-yellow-500 dark:text-yellow-400 hover:underline">Editar</a>
                                <form action="<?php echo e(route('sheets.destroy', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'sheet_hash' => $sheet->hash])); ?>" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500 dark:text-red-400 hover:underline">Excluir</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-600 dark:text-gray-300">Nenhuma ficha encontrada.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Arquivos</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="group bg-gray-100 dark:bg-gray-700 rounded-2xl shadow-lg p-6 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                            <div class="flex justify-center items-center mb-4">
                                <?php if($file->file_preview_path): ?>
                                    <img src="<?php echo e($file->file_preview_path); ?>" alt="Pré-visualização" class="w-20 h-20 rounded-full">
                                <?php else: ?>
                                    <svg class="w-16 h-16 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v18a2 2 0 002 2h10a2 2 0 002-2V3l-7 4-7-4z"/>
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2"><?php echo e($file->file_name); ?></h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4"><?php echo e($file->file_description ?? 'Sem descrição'); ?></p>
                            <a href="<?php echo e(route('files.show', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'file_hash' => $file->hash])); ?>" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Ver Arquivo</a>
                            <div class="mt-4 flex space-x-4">
                                <a href="<?php echo e(route('files.edit', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'file_hash' => $file->hash])); ?>" class="text-yellow-500 dark:text-yellow-400 hover:underline">Editar</a>
                                <form action="<?php echo e(route('files.destroy', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'file_hash' => $file->hash])); ?>" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500 dark:text-red-400 hover:underline">Excluir</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-600 dark:text-gray-300">Nenhum arquivo encontrado.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Botões de Ações -->
            <div class="flex flex-wrap gap-4 mt-8">
                <a href="<?php echo e(route('folders.create', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash])); ?>" class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-500 transition-all text-lg">Criar Pasta</a>
                <a href="<?php echo e(route('sheets.create', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash])); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-500 transition-all text-lg">Criar Ficha</a>
                <a href="<?php echo e(route('files.create', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash])); ?>" class="bg-gray-600 text-white px-6 py-3 rounded-full hover:bg-gray-500 transition-all text-lg">Criar Arquivo</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/folders/index.blade.php ENDPATH**/ ?>