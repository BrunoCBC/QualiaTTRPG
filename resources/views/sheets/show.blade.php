@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <!-- Header da Ficha -->
    <div class="flex flex-col md:flex-row items-center mb-8">
        <div class="w-full md:w-1/3 mb-4 md:mb-0">
            <div class="w-full rounded-lg" style="max-width: 300px; max-height: 300px; position: relative; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                <img src="{{ $sheet->sheet_image_path ? asset($sheet->sheet_image_path) : asset('img/profile.png') }}" 
                     alt="Imagem da Ficha" 
                     class="object-cover rounded-lg shadow-md" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
        <div class="w-full md:w-2/3 md:ml-6">
            <h1 class="text-4xl font-semibold text-gray-800 dark:text-white mb-4">
                {{ $sheet->sheet_name }}
            </h1>
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-6" 
               style="min-height: 1.5em; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                {{ $sheet->sheet_description }}
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-white mb-6">Gerenciar Atributos</h1>
    </div>

    <div class="bg-gray-800 p-4 rounded-lg mb-6">
        <ul class="flex space-x-4">
            <li><a href="#pc" class="tab-link text-white px-4 py-2 rounded-md hover:bg-gray-700" data-target="pc">PC</a></li>
            <li><a href="#pl" class="tab-link text-white px-4 py-2 rounded-md hover:bg-gray-700" data-target="pl">PL</a></li>
            <li><a href="#pm" class="tab-link text-white px-4 py-2 rounded-md hover:bg-gray-700" data-target="pm">PM</a></li>
            <li><a href="#pb" class="tab-link text-white px-4 py-2 rounded-md hover:bg-gray-700" data-target="pb">PB</a></li>
        </ul>
    </div>

    <form action="{{ route('rpg.attributes.store', ['rpg_hash' => $rpg->hash]) }}" method="POST" id="attributesForm">
        @csrf
        
        @foreach(['PC', 'PL', 'PM', 'PB'] as $type)
        <div id="{{ strtolower($type) }}" class="tab-pane hidden">
            <h3 class="text-2xl text-white mb-4">Atributos {{ $type }}</h3>
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse" id="{{ strtolower($type) }}Table">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-white">#</th>
                            <th class="px-4 py-2 text-left text-white">Nome do Atributo</th>
                            <th class="px-4 py-2 text-left text-white">Preço</th>
                            <th class="px-4 py-2 text-left text-white">Pontos Disponíveis</th>
                            <th class="px-4 py-2 text-center text-white">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($attributes->where('attributes_type', $type) as $attribute)
                        <tr>
                            <td class="px-4 py-2 text-white">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">
                                <input type="text" name="attributes[{{ $attribute->id }}][name]" value="{{ $attribute->attributes_name }}" class="w-full p-2 bg-gray-700 text-black rounded-md">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="attributes[{{ $attribute->id }}][price]" value="{{ $attribute->attributes_price }}" class="w-full p-2 bg-gray-700 text-black rounded-md">
                            </td>
                            <td class="px-4 py-2 text-center">
                                @php
                                    $pointsAvailableForType = $pointsAvailable[$attribute->attributes_type] ?? 0;
                                @endphp
                                <span class="text-white">{{ $pointsAvailableForType }} pontos</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md deleteRowBtn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md deleteRowBtn hidden sm:inline-block">
                                    Deletar
                                </button>
                            </td>
                            <input type="hidden" name="attributes[{{ $attribute->id }}][id]" value="{{ $attribute->id }}">
                            <input type="hidden" name="attributes[{{ $attribute->id }}][type]" value="{{ $type }}">
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="button" class="mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md" id="add{{ $type }}Row">Adicionar Atributo</button>
            </div>
        </div>
        @endforeach

        <div class="mt-4 flex justify-between items-center gap-4 sm:gap-6">
            <a href="{{ route('rpg.show', ['rpg_hash' => $rpg->hash]) }}" 
            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                Voltar
            </a>
            <button type="submit" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                Salvar Alterações
            </button>
        </div>

    </form>
</div>

<script>
const markUnsaved = (row, isNew = true) => {
    row.classList.add('bg-yellow-500');
    const statusCell = row.querySelector('.status-cell');
    if (statusCell) {
        statusCell.textContent = isNew ? 'Atributo não salvo' : 'Atributo modificado';
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabPanes = document.querySelectorAll('.tab-pane');
    const showTab = (targetId) => {
        tabPanes.forEach(pane => {
            pane.classList.add('hidden');
            const rows = pane.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const nameInput = row.querySelector('input[name$="[name]"]');
                const priceInput = row.querySelector('input[name$="[price]"]');
                const priceValue = parseFloat(priceInput.value);

                if (!nameInput.value.trim() && (isNaN(priceValue) || priceValue <= 0)) {
                    row.remove();
                }
            });
        });

        const targetPane = document.getElementById(targetId);
        if (targetPane) {
            targetPane.classList.remove('hidden');
        }
    };

    showTab('pc');
    tabLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const target = event.target.dataset.target;
            showTab(target);
        });
    });

    const addRow = (tableId, type) => {
        const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        const rowIndex = table.rows.length + 1;

        const row = table.insertRow();
        row.setAttribute('data-type', type);
        row.innerHTML = ` 
            <td class="px-4 py-2 text-white">${rowIndex}</td>
            <td class="px-4 py-2">
                <input type="text" name="attributes[new_${rowIndex}][name]" class="w-full p-2 bg-gray-700 text-black rounded-md">
            </td>
            <td class="px-4 py-2">
                <input type="number" name="attributes[new_${rowIndex}][price]" class="w-full p-2 bg-gray-700 text-black rounded-md">
            </td>
            <td class="px-4 py-2 text-center">
                <span class="text-white">0 pontos</span>
            </td>
            <td class="px-4 py-2 text-center">
                <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md deleteRowBtn">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md deleteRowBtn hidden sm:inline-block">
                    Deletar
                </button>
            </td>
            <input type="hidden" name="attributes[new_${rowIndex}][type]" value="${type}">
        `;
        const statusCell = document.createElement('td');
        statusCell.classList.add('px-4', 'py-2', 'text-white', 'status-cell');
        statusCell.textContent = 'Atributo não salvo';
        row.appendChild(statusCell);

        row.querySelector('.deleteRowBtn').addEventListener('click', (event) => {
            row.remove();
            updateIndices(tableId);
        });

        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', () => markUnsaved(row));
        });
    };

    const updateIndices = (tableId) => {
        const rows = document.getElementById(tableId).getElementsByTagName('tbody')[0].rows;
        for (let i = 0; i < rows.length; i++) {
            rows[i].cells[0].textContent = i + 1;
        }
    };

    ['PC', 'PL', 'PM', 'PB'].forEach(type => {
        document.getElementById(`add${type}Row`).addEventListener('click', () => {
            addRow(`${type.toLowerCase()}Table`, type);
        });
    });

    document.querySelectorAll('tbody tr').forEach(row => {
        const inputs = row.querySelectorAll('input');
        const attributeId = row.querySelector('input[name$="[id]"]')?.value;
        const isNew = !attributeId;

        const typeValue = row.querySelector('input[name$="[type]"]')?.value || row.getAttribute('data-type');

        inputs.forEach(input => {
            input.addEventListener('input', () => markUnsaved(row, isNew));
        });

        if (!isNew) {
            markUnsaved(row, false);
        }

        row.setAttribute('data-type', typeValue);
    });

    document.getElementById('attributesForm').addEventListener('submit', (event) => {
        event.preventDefault();
        const activeTab = document.querySelector('.tab-pane:not(.hidden)');
        const rows = activeTab.querySelectorAll('tbody tr');
        const attributesData = [];
        let allEmpty = true;

        rows.forEach(row => {
            const nameInput = row.querySelector('input[name$="[name]"]');
            const priceInput = row.querySelector('input[name$="[price]"]');
            const priceValue = parseFloat(priceInput.value);

            if (nameInput.value.trim() || (!isNaN(priceValue) && priceValue > 0)) {
                allEmpty = false;
            }
        });

        if (allEmpty) {
            alert('Todos os campos estão vazios! Adicione pelo menos um atributo.');
            return;
        }

        rows.forEach(row => {
            const nameInput = row.querySelector('input[name$="[name]"]');
            const priceInput = row.querySelector('input[name$="[price]"]');
            const priceValue = parseFloat(priceInput.value);
            const typeInput = row.getAttribute('data-type');
            
            if (!nameInput.value.trim() && (isNaN(priceValue) || priceValue <= 0)) {
                row.setAttribute('data-remove', 'true');
            } else {
                const attribute = {
                    id: row.querySelector('input[name$="[id]"]')?.value || null,
                    name: nameInput.value.trim(),
                    price: priceValue,
                    type: typeInput
                };
                attributesData.push(attribute);
            }
        });

        if (attributesData.length > 0) {
            event.target.submit();
        } else {
            alert('Não há atributos válidos para salvar.');
        }
    });
});

</script>
@endsection
