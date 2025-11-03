@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Crear nuevo plan de trazabilidad</h2>

<form method="POST" action="{{ route('supervisor.trace-plans.store') }}" class="bg-white p-6 rounded shadow-md">
    @csrf

    <label class="block mb-2 font-medium">Modelo FG</label>
    <select name="fg_model_id" class="w-full border rounded p-2 mb-4" required>
        <option value="">Seleccione modelo</option>
        @foreach($fgModels as $fg)
            <option value="{{ $fg->id }}">{{ $fg->fg_code }} — {{ $fg->description }}</option>
        @endforeach
    </select>

    <label class="block mb-2 font-medium">Versión del plan</label>
    <input type="number" name="version" value="1" class="w-full border rounded p-2 mb-4" min="1" required>

    <input type="hidden" name="created_by" value="{{ auth()->id() }}">

    <h3 class="text-lg font-semibold mt-6 mb-2">Requerimientos por estación</h3>
    <p class="text-gray-600 mb-4 text-sm">Agregue las estaciones y los tipos de componente o números de parte requeridos.</p>

    <div id="requirements-container">
        <div class="requirement border p-4 mb-3 rounded bg-gray-50">
            <label class="block mb-2 font-medium">Estación</label>
            <select name="requirements[0][station_id]" class="w-full border rounded p-2 mb-4" required>
                @foreach($stations as $st)
                    <option value="{{ $st->id }}">{{ $st->line->name }} — {{ $st->name }}</option>
                @endforeach
            </select>

            <label class="block mb-2 font-medium">Modo de requerimiento</label>
            <select name="requirements[0][requirement_mode]" class="w-full border rounded p-2 mb-4 mode-select" required>
                <option value="BY_TYPE">Por Tipo</option>
                <option value="BY_PART">Por Número de Parte</option>
            </select>

            <div class="by-type">
                <label class="block mb-2 font-medium">Tipo de componente</label>
                <select name="requirements[0][component_type_id]" class="w-full border rounded p-2 mb-4">
                    <option value="">Seleccione tipo</option>
                    @foreach($types as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="by-part hidden">
                <label class="block mb-2 font-medium">Número de parte</label>
                <input type="text" name="requirements[0][part_number]" class="w-full border rounded p-2 mb-4" placeholder="Ej: 281161165">
            </div>

            <label class="block mb-2 font-medium">Cantidad mínima</label>
            <input type="number" name="requirements[0][min_qty]" class="w-full border rounded p-2" value="1" required>
        </div>
    </div>

    <button type="button" id="add-requirement" class="bg-gray-700 text-white px-3 py-2 rounded mt-2">Agregar estación</button>

    <div class="mt-6">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar Plan</button>
        <a href="{{ route('supervisor.trace-plans.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </div>
</form>

<script>
let index = 1;
document.getElementById('add-requirement').addEventListener('click', () => {
    const container = document.getElementById('requirements-container');
    const template = container.firstElementChild.cloneNode(true);
    template.querySelectorAll('input, select').forEach(el => {
        const name = el.getAttribute('name');
        if (name) el.setAttribute('name', name.replace(/\d+/, index));
        if (el.tagName === 'INPUT') el.value = '';
    });
    container.appendChild(template);
    index++;
});

// Mostrar/ocultar campos según modo seleccionado
document.addEventListener('change', e => {
    if (e.target.classList.contains('mode-select')) {
        const wrapper = e.target.closest('.requirement');
        wrapper.querySelector('.by-type').classList.toggle('hidden', e.target.value !== 'BY_TYPE');
        wrapper.querySelector('.by-part').classList.toggle('hidden', e.target.value !== 'BY_PART');
    }
});
</script>
@endsection
