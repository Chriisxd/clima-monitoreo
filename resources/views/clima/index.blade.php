<div class="d-flex justify-content-end align-items-center mb-3 gap-3">
    <span class="text-gray-700">Usuario: <strong>{{ auth()->user()->name }}</strong></span>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-info btn-sm mt-2">Cerrar sesión</button>
    </form>
</div>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Monitoreo Climático</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <h1 class="mb-4 text-center"> Lista de Monitoreo Climático</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('clima.buscar') }}">
                @csrf
                <div class="row g-2">
                    <div class="col-md-9">
                        <input type="text" name="ciudad" class="form-control" placeholder="Ej: Quito" required>
                    </div>
                    <div class="col-md-3 d-grid">
                        <button class="btn btn-primary">Buscar clima</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Ciudad</th>
                        <th>Temp °C</th>
                        <th>Temp °F</th>
                        <th>Humedad</th>
                        <th>Condición</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($climas as $clima)
                        <tr>
                            <td>{{ $clima->ciudad }}</td>
                            <td>{{ $clima->temperatura }}</td>
                            <td>{{ $clima->temp_fahrenheit }}</td>
                            <td>{{ $clima->humedad }}%</td>
                            <td>{{ ucfirst($clima->condicion_clima) }}</td>
                            <td>{{ \Carbon\Carbon::parse($clima->fecha_consulta)->format('Y-m-d') }}</td>
                            <td class="d-flex gap-1">

                                <form action="{{ route('clima.update', $clima->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-info btn-sm">
                                        Actualizar
                                    </button>
                                </form>


                                <form action="{{ route('clima.destroy', $clima->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro quieres eliminar este clima?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>