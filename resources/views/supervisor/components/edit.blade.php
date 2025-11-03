@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Editar componente</h2>

<form method="POST" action="{{ route('supervisor.components.update', $component) }}" class="bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <label class="block mb-2 font-medium">Número de parte</label>
    <input 
        type="text" 
        value="{{ $component->part_number }}" 
        class="w-full border rounded p-2 mb-4 bg-gray-100" 
        disabled
    >

    <label class="block mb-2 font-medium">Descripción</label>
    <input 
        type="text" 
        name="description" 
        value="{{ old('description', $component->description) }}" 
        class="w-full border rounded p-2 mb-4"
    >

    <label class="block mb-2 font-medium">Tipo de componente</label>
    <select name="component_type_id" class="w-full border rounded p-2 mb-4">
        @foreach($types as $type)
            <option value="{{ $type->id }}" {{ $type->id == $component->component_type_id ? 'selected' : '' }}>
                {{ $type->name }}
            </option>
        @endforeach
    </select>

    <label class="inline-flex items-center mb-4">
        <input 
            type="checkbox" 
            name="is_active" 
            value="1" 
            {{ $component->is_active ? 'checked' : '' }}
            class="mr-2"
        >
        <span>Componente activo</span>
    </label>

    <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('supervisor.components.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </div>
</form>
@endsection
