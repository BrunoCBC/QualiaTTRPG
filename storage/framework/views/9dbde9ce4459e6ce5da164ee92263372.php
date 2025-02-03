

<?php $__env->startSection('content'); ?>
<div style="color: white; padding: 0.75rem; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.25rem; text-align: center;">Resumo da Rolagem de Dados</h2>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">
        <div class="p-4 bg-gray-800 rounded-lg shadow-md" style="margin-bottom: 1rem;">
            <p style="font-size: 1rem; font-weight: 600;">Composição da Rolagem</p>
            <p style="font-size: 1.25rem; font-weight: bold; padding-top: 0.5rem;">
                <?php if(isset($num_dice) && isset($dice_type) && isset($result_bonus)): ?>
                    <?php echo e($num_dice); ?>d<?php echo e($dice_type); ?><?php echo e($result_bonus > 0 ? ' + ' . $result_bonus : ''); ?>

                <?php else: ?>
                    N/A
                <?php endif; ?>
            </p>
            <p style="font-size: 1.25rem; font-weight: bold;">Número de Dados Iniciais: <?php echo e($num_dice ?? 'N/A'); ?></p>
            <p style="font-size: 1.25rem; font-weight: bold;">Total de Dados Rolados: <?php echo e(count($rolls)); ?></p>
        </div>

        <div class="p-4 bg-gray-800 rounded-lg shadow-md" style="margin-bottom: 1rem;">
            <p style="font-size: 1rem; font-weight: 600;">Resultado Total</p>
            <p style="font-size: 1.125rem; font-weight: bold; padding-top: 0.5rem;">Sem Bônus: <?php echo e($total_roll_before_bonus ?? 'N/A'); ?></p>
            <?php if($result_bonus > 0): ?>
                <p style="font-size: 1.125rem; font-weight: bold;">Com Bônus Aplicado: <?php echo e($total_roll_with_bonus ?? 'N/A'); ?> (Bônus: <?php echo e($result_bonus); ?>)</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">
        <?php if(($crit_up_count + $crit_down_count + ($hits_bonus ?? 0)) > 0): ?>
            <div class="p-4 bg-gray-800 rounded-lg shadow-md" style="margin-bottom: 1rem;">
                <p style="font-size: 1rem; font-weight: 600;">Acertos Críticos (Soma de Cima e Baixo)</p>
                <p style="font-size: 1.25rem; font-weight: bold; padding-top: 0.5rem;">
                    Total de Acertos (Sem Bônus): <?php echo e(($crit_up_count ?? 0) + ($crit_down_count ?? 0)); ?>

                </p>
                <?php if(($hits_bonus ?? 0) > 0): ?>
                    <p style="font-size: 1.125rem; font-weight: bold;">
                        Total de Acertos (Com Bônus): <?php echo e(($crit_up_count + $crit_down_count) + ($hits_bonus ?? 0)); ?> (Bônus: <?php echo e($hits_bonus); ?>)
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($crit_up_active || $crit_down_active): ?>
            <div class="p-4 bg-gray-800 rounded-lg shadow-md" style="margin-bottom: 1rem;">
                <p style="font-size: 1rem; font-weight: 600;">Acertos Críticos</p>
                <p style="font-size: 1.25rem; font-weight: bold; padding-top: 0.5rem;">Para Cima: <?php echo e($crit_up_count ?? 'N/A'); ?></p>
                <p style="font-size: 1.25rem; font-weight: bold;">Para Baixo: <?php echo e($crit_down_count ?? 'N/A'); ?></p>
                <p style="font-size: 1rem;">
                    Status: 
                    <?php if($reroll_up_active && $reroll_down_active): ?>
                        <span style="color: #48bb78;">Re-rolagem Ativa para ambos</span>
                    <?php elseif($reroll_up_active): ?>
                        <span style="color: #48bb78;">Re-rolagem para Cima Ativo</span>
                    <?php elseif($reroll_down_active): ?>
                        <span style="color: #48bb78;">Re-rolagem para Baixo Ativo</span>
                    <?php else: ?>
                        <span style="color: #f56565;">Re-rolagem Inativo</span>
                    <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <div class="p-4 bg-gray-800 rounded-lg shadow-md" style="margin-bottom: 1rem;">
        <p style="font-size: 1rem; font-weight: 600;">Número Mais Frequente</p>
        <p style="font-size: 1.25rem; font-weight: bold; padding-top: 0.5rem;"><?php echo e($highest_repeats ?? 'N/A'); ?></p>
    </div>

    <div style="margin-top: 1rem;">
        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.75rem;">Lista Completa de Dados</h3>
        <p style="background-color: #1a202c; padding: 0.75rem; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); font-size: 1rem;">
            <?php echo e(isset($rolls) ? implode(', ', $rolls) : 'Nenhum dado disponível'); ?>

        </p>
    </div>

    <div style="margin-top: 1rem; display: flex; justify-content: center; gap: 1rem;">
        <a href="<?php echo e(route('dices.index', ['rpg_hash' => $rpg_hash ?? ''])); ?>" 
        style="color: white; padding: 0.5rem 1.25rem; border-radius: 0.375rem; font-size: 1rem; font-weight: 600; transition: background-color 0.3s, transform 0.2s;">
        Voltar para as configurações de rolagem
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/dice/result.blade.php ENDPATH**/ ?>