<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nómina - DISFARMA</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body>

  <div class="sidebar-wrapper" id="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
      <i class="bi bi-asterisk"></i><span>DISFARMA HONDURAS</span>
    </a>
    <div class="flex-grow-1 overflow-y-auto">
      <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">Menu</div>
        <ul class="sidebar-menu-list">
          <li class="sidebar-menu-item">
            <a href="{{ route('dashboard') }}" class="sidebar-menu-link">
              <i class="bi bi-grid-fill"></i><span>Dashboard</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">Medicamentos</div>
        <ul class="sidebar-menu-list">
          <li class="sidebar-menu-item">
            <a href="{{ route('medicamentos.index') }}" class="sidebar-menu-link">
              <i class="bi bi-capsule"></i><span>Catálogo</span>
            </a>
          </li>
          <li class="sidebar-menu-item">
            <a href="{{ route('proveedores.index') }}" class="sidebar-menu-link">
              <i class="bi bi-input-cursor-text"></i><span>Proveedores</span>
            </a>
          </li>
          <li class="sidebar-menu-item">
            <a href="{{ route('empleados.index') }}" class="sidebar-menu-link active">
              <i class="bi bi-menu-button-wide-fill"></i><span>Empleados</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="sidebar-profile">
      <img src="{{ asset('assets/images/avatar.png') }}" alt="Administrator" class="sidebar-profile-img">
      <div class="sidebar-profile-info">
        <div class="sidebar-profile-name">{{ Auth::user()->usuario ?? 'Admin' }}</div>
        <div class="sidebar-profile-email">{{ Auth::user()->correo ?? 'admin@disfarma.hn' }}</div>
      </div>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="main-wrapper">
    <header class="navbar-custom">
      <div class="navbar-left">
        <button class="sidebar-toggle-btn me-2" id="sidebar-toggle"><i class="bi bi-list"></i></button>
      </div>
      <div class="navbar-actions">
        <div class="dropdown ms-2">
          <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <img src="{{ asset('assets/images/avatar.png') }}" class="navbar-profile-img">
            <span class="navbar-profile-name d-none d-md-inline">{{ Auth::user()->usuario ?? 'Admin' }}</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile">
            <li>
              <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> cerrar sesion </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </header>

    <div class="page-header d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="page-title">Nómina y Personal</h1>
            <p class="page-subtitle">Gestión de recursos humanos.</p>
        </div>
        <button type="button" class="btn btn-success" style="background-color: #1a432b; border-color: #1a432b;" data-bs-toggle="modal" data-bs-target="#modalEmpleado" id="btn-nuevo-empleado">
            <i class="bi bi-plus-lg"></i> Nuevo Empleado
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-stat mt-4 mb-4">
        <div class="card-body">
            <form action="{{ route('empleados.index') }}" method="GET" class="mb-4 d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre o identidad..." value="{{ $buscar ?? '' }}">
                <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-search"></i> Buscar</button>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Identidad</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Cargo</th>
                            <th>Salario</th>
                            <th>Ingreso</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($empleados as $empleado)
                            <tr>
                                <td><strong>{{ $empleado->identidad }}</strong></td>
                                <td>{{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                                <td>{{ $empleado->correo }}</td>
                                <td>
                                    <!-- Badges distintivos según el cargo -->
                                    @php
                                        $badgeColor = 'bg-secondary';
                                        if($empleado->cargo == 'Regente Farmacéutico') $badgeColor = 'bg-dark';
                                        elseif($empleado->cargo == 'Jefe de Bodega') $badgeColor = 'bg-primary';
                                        elseif($empleado->cargo == 'Asistente de Farmacia') $badgeColor = 'bg-info text-dark';
                                        elseif($empleado->cargo == 'Cajero') $badgeColor = 'bg-warning text-dark';
                                        elseif($empleado->cargo == 'Despachador') $badgeColor = 'bg-success';
                                    @endphp
                                    <span class="badge {{ $badgeColor }}">{{ $empleado->cargo }}</span>
                                </td>
                                <td>L. {{ number_format($empleado->salario, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $empleado->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">{{ $empleado->estado }}</span>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-editar" 
                                        data-id="{{ $empleado->id }}"
                                        data-identidad="{{ $empleado->identidad }}"
                                        data-nombre="{{ $empleado->nombre }}"
                                        data-apellido="{{ $empleado->apellido }}"
                                        data-correo="{{ $empleado->correo }}"
                                        data-cargo="{{ $empleado->cargo }}"
                                        data-salario="{{ $empleado->salario }}"
                                        data-ingreso="{{ $empleado->fecha_ingreso }}"
                                        data-estado="{{ $empleado->estado }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar a este empleado?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-4">No hay empleados registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">{{ $empleados->links() }}</div>
        </div>
    </div>

    <footer class="footer-custom">
      <div class="footer-left">
        <span class="footer-logo">
          <i class="bi bi-asterisk"></i> DISFARMA HONDURAS
        </span>
        <span class="footer-separator">|</span>
        <span class="footer-copy">&copy; 2026 Droguería y Distribuidora Farmacéutica San Rafael S. de R.L.</span>
      </div>
      <div class="footer-right">
        <ul class="footer-links">
          <li><a href="{{ route('dashboard') }}" class="footer-link">Dashboard</a></li>
          <li><a href="{{ route('medicamentos.index') }}" class="footer-link">Medicamentos</a></li>
          <li><a href="{{ route('proveedores.index') }}" class="footer-link">Proveedores</a></li>
          <li><a href="{{ route('empleados.index') }}" class="footer-link">Empleados <span class="status-dot"></span></a></li>
        </ul>
      </div>
    </footer>
  </div>

  <!-- MODAL DINÁMICO -->
  <div class="modal fade" id="modalEmpleado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1a432b; color: white;">
          <h5 class="modal-title" id="modalTituloEmpleado">Registrar Empleado</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        
        <form id="formEmpleado" action="{{ route('empleados.store') }}" method="POST">
          @csrf
          <div id="metodoDinamicoEmpleado"></div>
          
          <div class="modal-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                </div>
            @endif

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Identidad (13 dígitos) <span class="text-danger">*</span></label>
                <input type="text" name="identidad" id="input-identidad" class="form-control" maxlength="13" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                <input type="email" name="correo" id="input-correo" class="form-control" required>
              </div>
              
              <div class="col-md-6">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="input-nombre" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Apellido <span class="text-danger">*</span></label>
                <input type="text" name="apellido" id="input-apellido" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Cargo <span class="text-danger">*</span></label>
                <select name="cargo" id="input-cargo" class="form-select" required>
                  <option value="">Seleccione...</option>
                  <option value="Regente Farmacéutico">Regente Farmacéutico</option>
                  <option value="Asistente de Farmacia">Asistente de Farmacia</option>
                  <option value="Jefe de Bodega">Jefe de Bodega</option>
                  <option value="Despachador">Despachador</option>
                  <option value="Cajero">Cajero</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Estado <span class="text-danger">*</span></label>
                <select name="estado" id="input-estado" class="form-select" required>
                  <option value="Activo">Activo</option>
                  <option value="Inactivo">Inactivo</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Salario Mensual (L.) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="salario" id="input-salario" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Fecha de Ingreso <span class="text-danger">*</span></label>
                <input type="date" name="fecha_ingreso" id="input-ingreso" class="form-control" required>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" id="btn-submit-empleado" class="btn btn-success" style="background-color: #1a432b; border-color: #1a432b;">Guardar Empleado</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  
  <script>
  document.addEventListener("DOMContentLoaded", function() {
      const form = document.getElementById('formEmpleado');
      const modalTitulo = document.getElementById('modalTituloEmpleado');
      const btnSubmit = document.getElementById('btn-submit-empleado');
      const metodoDinamico = document.getElementById('metodoDinamicoEmpleado');

      document.getElementById('btn-nuevo-empleado').addEventListener('click', function() {
          form.reset();
          form.action = "{{ route('empleados.store') }}";
          modalTitulo.textContent = 'Registrar Nuevo Empleado';
          btnSubmit.textContent = 'Guardar Empleado';
          metodoDinamico.innerHTML = '';
      });

      document.querySelectorAll('.btn-editar').forEach(button => {
          button.addEventListener('click', function() {
              const id = this.getAttribute('data-id');
              
              document.getElementById('input-identidad').value = this.getAttribute('data-identidad');
              document.getElementById('input-nombre').value = this.getAttribute('data-nombre');
              document.getElementById('input-apellido').value = this.getAttribute('data-apellido');
              document.getElementById('input-correo').value = this.getAttribute('data-correo');
              document.getElementById('input-cargo').value = this.getAttribute('data-cargo');
              document.getElementById('input-salario').value = this.getAttribute('data-salario');
              document.getElementById('input-ingreso').value = this.getAttribute('data-ingreso');
              document.getElementById('input-estado').value = this.getAttribute('data-estado');
              
              form.action = `/empleados/${id}`;
              modalTitulo.textContent = 'Editar Empleado';
              btnSubmit.textContent = 'Actualizar Empleado';
              metodoDinamico.innerHTML = '@method("PUT")';

              var myModal = new bootstrap.Modal(document.getElementById('modalEmpleado'));
              myModal.show();
          });
      });
  });
  </script>
  
</body>
</html>