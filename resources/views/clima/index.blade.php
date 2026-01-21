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
            <form id="formBuscarCiudad" method="POST" action="{{ route('clima.buscar') }}">
                @csrf
                <div class="row g-2">
                    <div class="col-md-9">
                        <input type="text" name="ciudad" class="form-control" placeholder="Ej: Quito">
                        <div class="invalid-feedback">Debes ingresar el nombre de la ciudad.</div>
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
                            <td class="d-flex flex-column gap-1">

                                <div class="d-flex gap-1 mb-1">
                                    <form action="{{ route('clima.update', $clima->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
                                    </form>

                                    <form class="formEliminarClima" action="{{ route('clima.destroy', $clima->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>

                                <form class="formAgregarComentario d-flex gap-1" action="{{ route('comentarios.store', $clima->id) }}" method="POST">
                                    @csrf
                                    <input type="text" name="contenido" class="form-control form-control-sm" placeholder="Añadir comentario...">
                                    <div class="invalid-feedback">El comentario no puede estar vacío.</div>
                                    <button type="submit" class="btn btn-primary btn-sm">Comentar</button>
                                </form>

                                <button type="button" class="btn btn-secondary btn-sm mt-1" data-bs-toggle="collapse" data-bs-target="#comentarios-{{ $clima->id }}">
                                    Ver Comentarios ({{ $clima->comentarios->count() }})
                                </button>

  
                                <div id="comentarios-{{ $clima->id }}" class="collapse mt-1">
                                    <ul class="list-group list-group-flush">
                                        @forelse($clima->comentarios as $comentario)
                                            <li class="list-group-item py-1 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $comentario->user->name ?? 'Anon' }}:</strong>
                                                    {{ $comentario->contenido }}
                                                    <small class="text-muted">({{ $comentario->created_at->diffForHumans() }})</small>
                                                </div>

                                                <div class="d-flex gap-1">
   
                                                    <form class="formEditarComentario" action="{{ route('comentarios.update', $comentario->id) }}" method="POST" style="display:inline-flex;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="text" name="contenido" value="{{ $comentario->contenido }}" class="form-control form-control-sm" readonly>
                                                        <div class="invalid-feedback">El comentario no puede estar vacío.</div>
                                                        <button type="button" class="btn btn-sm btn-warning btnEditar">Editar</button>
                                                        <button type="submit" class="btn btn-sm btn-success btnGuardar" style="display:none;">Guardar</button>
                                                        <button type="button" class="btn btn-sm btn-secondary btnCancelar" style="display:none;">Cancelar</button>
                                                    </form>

                                                    <form class="formEliminarComentario" action="{{ route('comentarios.destroy', $comentario->id) }}" method="POST" style="display:inline-flex;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="list-group-item py-1 text-muted">Sin comentarios</li>
                                        @endforelse
                                    </ul>
                                </div>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

function confirmarEliminarClima() {
    return confirm("¿Seguro quieres eliminar este clima?");
}

function confirmarEliminarComentario() {
    return confirm("¿Eliminar comentario?");
}


const inputCiudad = document.querySelector('input[name="ciudad"]');
const formBuscarCiudad = document.getElementById('formBuscarCiudad');

inputCiudad.addEventListener('input', function() {
    if (this.value.trim() === '') {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});

formBuscarCiudad.addEventListener('submit', function(e) {
    if (inputCiudad.value.trim() === '') {
        alert("Debes ingresar el nombre de la ciudad.");
        inputCiudad.classList.add('is-invalid');
        e.preventDefault();
    }
});


document.querySelectorAll('.formAgregarComentario').forEach(function(form) {
    const input = form.querySelector('input[name="contenido"]');

    input.addEventListener('input', function() {
        if (this.value.trim() === '') {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    form.addEventListener('submit', function(e) {
        if (input.value.trim() === '') {
            alert("El comentario no puede estar vacío.");
            input.classList.add('is-invalid');
            e.preventDefault();
        }
    });
});

document.querySelectorAll('.formEliminarClima').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        if(!confirmarEliminarClima()) e.preventDefault();
    });
});

document.querySelectorAll('.formEliminarComentario').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        if(!confirmarEliminarComentario()) e.preventDefault();
    });
});

document.querySelectorAll('.formEditarComentario').forEach(function(form) {
    const input = form.querySelector('input[name="contenido"]');
    const btnEditar = form.querySelector('.btnEditar');
    const btnGuardar = form.querySelector('.btnGuardar');
    const btnCancelar = form.querySelector('.btnCancelar');

    let valorOriginal = input.value;

    btnEditar.addEventListener('click', function() {
        input.removeAttribute('readonly');
        input.focus();
        btnEditar.style.display = 'none';
        btnGuardar.style.display = 'inline-block';
        btnCancelar.style.display = 'inline-block';
    });


    btnCancelar.addEventListener('click', function() {
        input.value = valorOriginal;
        input.setAttribute('readonly', true);
        btnEditar.style.display = 'inline-block';
        btnGuardar.style.display = 'none';
        btnCancelar.style.display = 'none';
        input.classList.remove('is-invalid');
    });

 
    input.addEventListener('input', function() {
        if (this.value.trim() === '') {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    form.addEventListener('submit', function(e) {
        if (!input.value.trim()) {
            alert("El comentario no puede estar vacío.");
            input.classList.add('is-invalid');
            e.preventDefault();
        }
    });
});
</script>

</body>
</html>