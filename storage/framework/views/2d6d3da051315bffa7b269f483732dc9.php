

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto" style="padding: 40px;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md" style="padding: 30px;">
            <div class="flex flex-col md:flex-row items-center" style="margin-bottom: 30px;">
                <div class="w-full md:w-1/3" style="margin-bottom: 20px;">
                    <div class="w-full rounded-lg" style="max-width: 300px; max-height: 300px; position: relative; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                        <img src="<?php echo e($rpg->rpg_image_path ? asset($rpg->rpg_image_path) : asset('img/profile.png')); ?>" 
                            alt="Imagem do RPG" 
                            class="object-cover rounded-lg shadow-md" 
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                <div class="w-full md:w-2/3 md:ml-6">
                    <h1 class="text-4xl font-semibold text-gray-800 dark:text-white" style="margin-bottom: 20px;">
                        <?php echo e($rpg->rpg_name); ?>

                    </h1>
                    <p class="text-lg text-gray-700 dark:text-gray-300" 
                       style="margin-bottom: 30px; 
                              min-height: 1.5em; /* Garante uma linha de altura mesmo sem conteúdo */ 
                              overflow: hidden; 
                              text-overflow: ellipsis; 
                              white-space: nowrap;">
                        <?php echo e($rpg->rpg_description); ?>

                    </p>
                    <div class="flex justify-start" style="margin-top: 20px; gap: 15px;">
                        <a href="<?php echo e(route('rpg.edit', $rpg->hash)); ?>" 
                            class="text-white rounded-md"
                            style="background-color: #3B82F6; padding: 12px 20px; font-weight: bold; text-decoration: none;">
                            Editar
                        </a>
                        <form action="<?php echo e(route('rpg.destroy', $rpg->hash)); ?>" method="POST"
                            onsubmit="return confirm('Você tem certeza que deseja excluir este RPG?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                class="text-white rounded-md"
                                style="background-color: #EF4444; padding: 12px 20px; font-weight: bold; border: none;">
                                Deletar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4" style="gap: 20px;">
                <div class="bg-gray-100 dark:bg-gray-700 text-center rounded-lg shadow-lg hover:shadow-xl transition-all" 
                    style="padding: 20px;">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white" style="margin-bottom: 15px;">Tabelas</h3>
                    <p class="text-gray-600 dark:text-gray-300" style="margin-bottom: 15px;">
                        Veja as tabelas de atributos e níveis do RPG.
                    </p>
                    <a href="<?php echo e(route('rpg.attributes.index', $rpg->hash)); ?>" class="text-blue-500 hover:text-blue-400">Atributos</a> | 
                    <a href="<?php echo e(route('rpg.levels.index', $rpg->hash)); ?>" class="text-blue-500 hover:text-blue-400">Níveis</a>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 text-center rounded-lg shadow-lg hover:shadow-xl transition-all" 
                    style="padding: 20px;">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white" style="margin-bottom: 15px;">Tipos de Ficha</h3>
                    <p class="text-gray-600 dark:text-gray-300" style="margin-bottom: 15px;">
                        Gerencie os tipos de ficha do seu RPG.
                    </p>
                    <a href="<?php echo e(route('sheettypes.index', $rpg->hash)); ?>" class="text-blue-500 hover:text-blue-400">Ver Tipos de Ficha</a>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 text-center rounded-lg shadow-lg hover:shadow-xl transition-all" 
                    style="padding: 20px;">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white" style="margin-bottom: 15px;">Dados</h3>
                    <p class="text-gray-600 dark:text-gray-300" style="margin-bottom: 15px;">
                        Role os dados do seu RPG.
                    </p>
                    <a href="<?php echo e(route('dices.roll', $rpg->hash)); ?>" class="text-blue-500 hover:text-blue-400">Ir para Rolagem</a>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 text-center rounded-lg shadow-lg hover:shadow-xl transition-all" 
                    style="padding: 20px;">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white" style="margin-bottom: 15px;">Pastas</h3>
                    <p class="text-gray-600 dark:text-gray-300" style="margin-bottom: 15px;">
                        Acesse as pastas do RPG para organizar seu conteúdo.
                    </p>
                    <a href="<?php echo e(route('folders.index', $rpg->hash)); ?>" class="text-blue-500 hover:text-blue-400">Ver Pastas</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/rpg/show.blade.php ENDPATH**/ ?>