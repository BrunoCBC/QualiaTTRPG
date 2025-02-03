

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4">
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-white">Tipos de Ficha para RPG: <?php echo e($rpg->name); ?></h1>
    </div>

    <div class="bg-gray-800 p-4 rounded-lg mb-6">
        <a href="<?php echo e(route('sheettypes.create', ['rpg_hash' => $rpg->hash])); ?>" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
            Criar Novo Tipo de Ficha
        </a>
    </div>

    <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
        <?php if($sheetTypes->isEmpty()): ?>
            <p class="text-white">Nenhum tipo de ficha encontrado.</p>
        <?php else: ?>
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-white">Nome</th>
                        <th class="px-4 py-2 text-left text-white">Descrição</th>
                        <th class="px-4 py-2 text-left text-white">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $sheetTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheetType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-4 py-2 text-white"><?php echo e($sheetType->sheettype_name); ?></td>
                            <td class="px-4 py-2 text-white"><?php echo e($sheetType->sheettype_description); ?></td>
                            <td class="px-4 py-2 text-white">
                                <a href="<?php echo e(route('sheettypes.edit', ['rpg_hash' => $rpg->hash, 'sheettype_hash' => $sheetType->id])); ?>" 
                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md">
                                    Editar
                                </a>
                                <form action="<?php echo e(route('sheettypes.destroy', ['rpg_hash' => $rpg->hash, 'sheettype_hash' => $sheetType->id])); ?>" 
                                    method="POST" class="inline-block">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                                        Deletar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div class="mt-6 flex justify-between items-center">
        <a href="<?php echo e(route('rpg.show', ['rpg_hash' => $rpg->hash])); ?>" 
            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
            Voltar
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/sheettypes/index.blade.php ENDPATH**/ ?>