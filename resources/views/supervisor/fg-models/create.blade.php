@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Registrar nuevo modelo FG</h2>

<form method="POST" action="{{ route('supervisor.fg-models.store') }}" class="bg-white p-6 rounded shadow-md">
    @csrf

    <label class="block mb-2 font-medium">Código FG</label>
    <input type="text" name="fg_code" class="w-full border rounded p-2 mb-4" placeholder="Ej: 103368013" required>

    <label class="block mb-2 font-medium">Descripción</label>
    <input type="text" name="description" class="w-full border rounded p-2 mb-4" placeholder="Ej: Taladro inalámbrico M18" required>

    <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('supervisor.fg-models.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </div>
</form>
@endsection
