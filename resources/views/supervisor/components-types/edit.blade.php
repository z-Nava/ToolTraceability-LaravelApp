@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Editar tipo de componente</h2>

<form method="POST" action="{{ route('supervisor.component-types.update', $componentType) }}" class="bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <label class="block mb-2 font-medium">Código</label>
    <input 
        type="text" 
        value="{{ $componentType->code }}" 
        class="w-full border rounded p-2 mb-4 bg-gray-100" 
        disabled
    >

    <label class="block mb-2 font-medium">Nombre</label>
    <input 
        type="text" 
        name="name" 
        value="{{ old('name', $componentType->name) }}" 
        class="w-full border rounded p-2 mb-4" 
        required
    >

    <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('supervisor.component-types.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </div>
</form>
@endsection
