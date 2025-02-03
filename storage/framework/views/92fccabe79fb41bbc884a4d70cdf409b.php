

<?php $__env->startSection('content'); ?>
<div class="container mx-auto" style="padding: 2rem 1rem;">
    <h1 class="text-4xl font-bold text-white text-center" style="margin-bottom: 1.5rem;">Rolar Dados</h1>

    <form action="<?php echo e(route('dices.roll', ['rpg_hash' => $rpg_hash])); ?>" method="POST" id="diceForm">
        <?php echo csrf_field(); ?>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="dice_type" class="block text-white font-semibold">Tipo de Dado</label>
                    <div class="flex items-center" style="gap: 1rem;">
                        <input type="number" name="dice_type" id="dice_type" value="6" min="1" 
                            class="bg-gray-700 text-black rounded-md" style="width: 6rem; padding: 0.5rem;">
                        <div class="flex" style="gap: 1rem;">
                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white rounded-md px-4 py-2" onclick="setDiceType(4)">D4</button>
                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white rounded-md px-4 py-2" onclick="setDiceType(6)">D6</button>
                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white rounded-md px-4 py-2" onclick="setDiceType(8)">D8</button>
                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white rounded-md px-4 py-2" onclick="setDiceType(10)">D10</button>
                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white rounded-md px-4 py-2" onclick="setDiceType(12)">D12</button>
                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white rounded-md px-4 py-2" onclick="setDiceType(20)">D20</button>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="num_dice" class="block text-white font-semibold">Quantidade de Dados</label>
                    <input type="number" name="num_dice" id="num_dice" value="1" min="1" 
                        class="bg-gray-700 text-black rounded-md" style="width: 100%; padding: 0.5rem;">
                </div>
            </div>

            <div id="errorMessages" style="margin-top: 1.5rem;"></div>

            <div class="flex flex-wrap gap-6 mt-6" style="flex-direction: row; flex-wrap: wrap;">
                <div class="flex-1 bg-gray-700 p-4 rounded-lg shadow-md" style="width: 48%; min-width: 280px;">
                    <h3 class="text-xl font-bold text-white">Configurações de Críticos</h3>
                    <div style="margin-top: 1.5rem;">
                        <div>
                            <label for="crit_up" class="block text-white font-semibold">Crítico Superior (≥)</label>
                            <div class="flex items-center" style="gap: 1rem;">
                                <input type="number" name="crit_up" id="crit_up" value="3" class="bg-gray-600 text-black rounded-md" style="width: 6rem; padding: 0.5rem;">
                                <input type="hidden" name="count_crit_up_checkbox" value="false">
                                <label for="count_crit_up_checkbox" class="inline-flex items-center text-white">
                                    <input type="checkbox" name="count_crit_up_checkbox" id="count_crit_up_checkbox" class="mr-2" value="true">
                                    Contar críticos superiores
                                </label>
                                <label for="crit_up_checkbox" class="inline-flex items-center text-white">
                                    <input type="checkbox" name="crit_up_checkbox" id="crit_up_checkbox" class="mr-2">
                                    Re-rolar se atingir
                                </label>
                            </div>
                        </div>

                        <div style="margin-top: 1rem;">
                            <label for="crit_down" class="block text-white font-semibold">Crítico Inferior (≤)</label>
                            <div class="flex items-center" style="gap: 1rem;">
                                <input type="number" name="crit_down" id="crit_down" value="3" class="bg-gray-600 text-black rounded-md" style="width: 6rem; padding: 0.5rem;">
                                <input type="hidden" name="count_crit_down_checkbox" value="false">
                                <label for="count_crit_down_checkbox" class="inline-flex items-center text-white">
                                    <input type="checkbox" name="count_crit_down_checkbox" id="count_crit_down_checkbox" class="mr-2" value="true">
                                    Contar críticos inferiores
                                </label>
                                <label for="crit_down_checkbox" class="inline-flex items-center text-white">
                                    <input type="checkbox" name="crit_down_checkbox" id="crit_down_checkbox" class="mr-2">
                                    Re-rolar se atingir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1 bg-gray-700 p-4 rounded-lg shadow-md" style="width: 48%; min-width: 280px;">
                    <h3 class="text-xl font-bold text-white">Configurações de Bônus</h3>
                    <div style="margin-top: 1.5rem;">
                        <div>
                            <label for="result_bonus" class="block text-white font-semibold">Bônus de Resultado</label>
                            <input type="number" name="result_bonus" id="result_bonus" value="0" class="bg-gray-600 text-black rounded-md" style="width: 6rem; padding: 0.5rem;">
                        </div>

                        <div style="margin-top: 1rem;">
                            <label for="hits_bonus" class="block text-white font-semibold">Bônus de Acertos</label>
                            <input type="number" name="hits_bonus" id="hits_bonus" value="0" class="bg-gray-600 text-black rounded-md" style="width: 6rem; padding: 0.5rem;">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: space-between; align-items: center;">
            <a href="<?php echo e(route('rpg.show', ['rpg_hash' => $rpg_hash])); ?>" 
                class="bg-gray-600 hover:bg-gray-700 text-white rounded-md" style="padding: 0.5rem 1.5rem;">
                Voltar
            </a>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button type="reset" id="resetForm" class="bg-gray-600 hover:bg-gray-700 text-white rounded-md" style="padding: 0.5rem 1.5rem;">
                    Resetar
                </button>
                <button type="submit" id="rollDiceButton" class="bg-blue-600 hover:bg-blue-700 text-white rounded-md" style="padding: 0.5rem 1.5rem;">
                    Rolar Dados
                </button>
            </div>
        </div>

    </form>
</div>

<script>
function setDiceType(sides) {
    document.getElementById('dice_type').value = sides;
}

document.addEventListener('DOMContentLoaded', () => {
    const rollDiceButton = document.getElementById('rollDiceButton');
    const form = document.getElementById('diceForm');
    const errorMessages = document.getElementById('errorMessages');
    const diceTypeInput = document.getElementById('dice_type');
    const critUpInput = document.getElementById('crit_up');
    const critDownInput = document.getElementById('crit_down');
    const countCritUpCheckbox = document.getElementById('count_crit_up_checkbox');
    const countCritDownCheckbox = document.getElementById('count_crit_down_checkbox');

    form.addEventListener('submit', function(event) {
        errorMessages.innerHTML = '';
        let valid = true;

        const critUpValue = parseInt(critUpInput.value);
        const critDownValue = parseInt(critDownInput.value);
        const diceSides = parseInt(diceTypeInput.value);

        if (critUpValue === critDownValue && crit_up_checkbox.checked && crit_down_checkbox.checked || Math.abs(critUpValue - critDownValue) <= 1 && crit_up_checkbox.checked && crit_down_checkbox.checked) {
            const errorMessage = document.createElement('label');
            errorMessage.classList.add('text-red-500');
            errorMessage.textContent = 'Os valores de críticos não podem se sobrepor ou não abrir espaço para "erro". Ajuste os valores críticos.';
            errorMessages.appendChild(errorMessage);
            valid = false;
        }

        if (critUpValue === 1 && crit_up_checkbox.checked) {
            const errorMessage = document.createElement('label');
            errorMessage.classList.add('text-red-500');
            errorMessage.textContent = 'Crítico superior não pode ter o valor como 1';
            errorMessages.appendChild(errorMessage);
            valid = false;
        }

        if (critDownValue === diceSides && crit_down_checkbox.checked) {
            const errorMessage = document.createElement('label');
            errorMessage.classList.add('text-red-500');
            errorMessage.textContent = 'Crítico inferior não pode ter o mesmo valor da quantidade de faces do dado';
            errorMessages.appendChild(errorMessage);
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
            rollDiceButton.disabled = false;

            const errorMessage = document.createElement('div');
            errorMessage.classList.add('bg-red-500', 'text-white', 'p-2', 'rounded-md', 'mt-4');
            errorMessage.innerHTML = 'Corrija os erros para continuar.';
            errorMessages.appendChild(errorMessage);
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\trall\OneDrive\Documentos\TCC\WEB\QualiaTTRPG\resources\views/dice/index.blade.php ENDPATH**/ ?>