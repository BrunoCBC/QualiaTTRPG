

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4">
    <?php if($rpg->sheetTypes->isEmpty()): ?>
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-white">Nenhum Tipo de Ficha Cadastrado</h1>
    </div>
        <div class="text-center mb-6">
            <a href="<?php echo e(route('sheettypes.create', ['rpg_hash' => $rpg->hash])); ?>" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">
                Criar Novo Tipo de Ficha
            </a>
        </div>
        <div class="mt-6 flex justify-between items-center">
            <a href="<?php echo e(route('rpg.show', ['rpg_hash' => $rpg->hash])); ?>" 
                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                Voltar
            </a>
        </div>
    <?php else: ?>
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-white">Gerenciar Níveis</h1>
    </div>
        <div class="bg-gray-800 p-4 rounded-lg mb-6">
            <ul class="flex space-x-4">
                <?php $__currentLoopData = $rpg->sheetTypes->unique('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheetType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="#sheettype-<?php echo e($sheetType->id); ?>" 
                           class="tab-link text-white px-4 py-2 rounded-md hover:bg-gray-700" 
                           data-target="sheettype-<?php echo e($sheetType->id); ?>">
                            <?php echo e($sheetType->sheettype_name); ?>

                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <form action="<?php echo e(route('rpg.levels.store', ['rpg_hash' => $rpg->hash])); ?>" method="POST" id="levelsForm">
            <?php echo csrf_field(); ?>
            
            <?php
                $firstHalf = range(0, 4);
                $secondHalf = range(5, 9);
            ?>

            <?php $__currentLoopData = $rpg->sheetTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheetType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="tab-pane hidden" id="sheettype-<?php echo e($sheetType->id); ?>">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-2xl text-white mb-4">Níveis para o Tipo de Ficha: <?php echo e($sheetType->sheettype_name); ?></h3>

                        <a href="<?php echo e(route('sheettypes.index', ['rpg_hash' => $rpg->hash])); ?>" 
                           class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">
                            Gerenciar Tipos de Ficha
                        </a>
                    </div>

                    <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                        <div class="flex justify-between">
                            <div class="w-1/2 pr-2">
                                <table class="min-w-full table-auto border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left text-white">Nível</th>
                                            <th class="px-4 py-2 text-left text-white">PC</th>
                                            <th class="px-4 py-2 text-left text-white">PL</th>
                                            <th class="px-4 py-2 text-left text-white">PM</th>
                                            <th class="px-4 py-2 text-left text-white">PB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $firstHalf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $levelData = $sheetType->levels->where('level', $level)->first();
                                            ?>
                                            <tr>
                                                <td class="px-4 py-2 text-white"><?php echo e($level); ?></td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[<?php echo e($sheetType->id); ?>][<?php echo e($level); ?>][pc]" 
                                                           value="<?php echo e($levelData->pc ?? 1); ?>" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[<?php echo e($sheetType->id); ?>][<?php echo e($level); ?>][pl]" 
                                                           value="<?php echo e($levelData->pl ?? 1); ?>" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[<?php echo e($sheetType->id); ?>][<?php echo e($level); ?>][pm]" 
                                                           value="<?php echo e($levelData->pm ?? 1); ?>" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[<?php echo e($sheetType->id); ?>][<?php echo e($level); ?>][pb]" 
                                                           value="<?php echo e($levelData->pb ?? 1); ?>" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="w-1/2 pl-2">
                                <table class="min-w-full table-auto border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left text-white">Nível</th>
                                            <th class="px-4 py-2 text-left text-white">PC</th>
                                            <th class="px-4 py-2 text-left text-white">PL</th>
                                            <th class="px-4 py-2 text-left text-white">PM</th>
                                            <th class="px-4 py-2 text-left text-white">PB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $secondHalf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $levelData = $sheetType->levels->where('level', $level)->first();
                                            ?>
                                            <tr>
                                                <td class="px-4 py-2 text-white"><?php echo e($level); ?></td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[<?php echo e($sheetType->id); ?>][<?php echo e($level); ?>][pc]" 
                                                           value="<?php echo e($levelData->pc ?? 1); ?>" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[<?php echo e($sheetType->id); ?>][<?php echo e($level); ?>][pl]" 
                                                           value="<?php echo e($levelData->pl ?? 1); ?>" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[<?php echo e($sheetType->id); ?>][<?php echo e($level); ?>][pm]" 
                                                           value="<?php echo e($levelData->pm ?? 1); ?>" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[<?php echo e($sheetType->id); ?>][<?php echo e($level); ?>][pb]" 
                                                           value="<?php echo e($levelData->pb ?? 1); ?>" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="mt-6 flex justify-between items-center">
                <a href="<?php echo e(route('rpg.show', ['rpg_hash' => $rpg->hash])); ?>" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                    Voltar
                </a>
                <button type="submit" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                    Salvar Alterações
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabLinks = document.querySelectorAll('.tab-link');
    const form = document.getElementById('levelsForm');

    const showTab = (targetId) => {
        const tabPanes = document.querySelectorAll('.tab-pane');
        tabPanes.forEach(pane => pane.classList.add('hidden'));
        document.getElementById(targetId)?.classList.remove('hidden');
    };

    showTab('sheettype-<?php echo e($rpg->sheetTypes->isNotEmpty() ? $rpg->sheetTypes->first()->id : ''); ?>');

    tabLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const target = event.target.dataset.target;
            showTab(target);
        });
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/rpg/levels.blade.php ENDPATH**/ ?>