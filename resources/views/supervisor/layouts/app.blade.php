<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Supervisor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gray-800 text-white p-4">
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-bold">Panel Supervisor</h1>
            <div>
                <a href="{{ route('supervisor.lines.index') }}" class="mx-2 hover:underline">Líneas</a>
                <a href="{{ route('supervisor.stations.index') }}" class="mx-2 hover:underline">Estaciones</a>
                <a href="{{ route('supervisor.fg-models.index') }}" class="mx-2 hover:underline">Modelos FG</a>
                <a href="{{ route('supervisor.components.index') }}" class="mx-2 hover:underline">Componentes</a>
                <a href="{{ route('supervisor.trace-plans.index') }}" class="mx-2 hover:underline">Planes</a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto py-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
