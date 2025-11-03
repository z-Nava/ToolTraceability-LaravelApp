@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Detalles del Plan #{{ $tracePlan->id }}</h2>

<div class="bg-white p-6 rounded shadow-md">
    <p><strong>Modelo FG:</strong> {{ $tracePlan->fgModel->fg_code }} - {{ $tracePlan->fgModel->description }}</p>
    <p><strong>Versión:</strong> {{ $tracePlan->version }}</p>
    <p><strong>Activo:</strong> {{ $tracePlan->is_active ? 'Sí' : 'No' }}</p>

    <h3 class="text-lg font-semibold mt-6 mb-2">Requerimientos</h3>
    <table class="min-w-full bg-white border rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 text-left">Estación</th>
                <th class="py-2 px-4 text-left">Modo</th>
                <th class="py-2 px-4 text-left">Tipo / Nº Parte</th>
                <th class="py-2 px-4 text-left">Cantidad Mínima</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tracePlan->requirements as $req)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $req->station->name }}</td>
                <td class="py-2 px-4">{{ $req->requirement_mode }}</td>
                <td class="py-2 px-4">
                    {{ $req->requirement_mode == 'BY_TYPE' ? $req->componentType->name : $req->part_number }}
                </td>
                <td class="py-2 px-4">{{ $req->min_qty }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
