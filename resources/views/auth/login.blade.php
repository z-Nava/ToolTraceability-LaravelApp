<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-sm">
        <h1 class="text-2xl font-bold mb-4 text-center">Inicio de sesión</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-2 mb-4 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label class="block mb-2 text-sm font-medium">Correo o Nº Empleado</label>
            <input type="text" name="login" value="{{ old('login') }}" required class="w-full border px-3 py-2 rounded mb-4">

            <label class="block mb-2 text-sm font-medium">Contraseña</label>
            <input type="password" name="password" required class="w-full border px-3 py-2 rounded mb-6">

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                Entrar
            </button>
        </form>
    </div>
</body>
</html>
