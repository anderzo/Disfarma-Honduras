<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proveedores - DISFARMA</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body>

  <!-- SIDEBAR -->
  <div class="sidebar-wrapper" id="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
      <i class="bi bi-asterisk"></i>
      <span>DISFARMA HONDURAS</span>
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
            <a href="{{ route('proveedores.index') }}" class="sidebar-menu-link active">
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
                <button type="submit" class="dropdown-item text-danger">
                  <i class="bi bi-box-arrow-right"></i> cerrar sesion
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </header>

    <div class="page-header d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="page-title">Directorio de Proveedores</h1>
            <p class="page-subtitle">Gestión de mayoristas y laboratorios.</p>
        </div>
        <button type="button" class="btn btn-success" style="background-color: #1a432b; border-color: #1a432b;" data-bs-toggle="modal" data-bs-target="#modalProveedor" id="btn-nuevo-proveedor">
            <i class="bi bi-plus-lg"></i> Nuevo Proveedor
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
            <!-- Buscador -->
            <form action="{{ route('proveedores.index') }}" method="GET" class="mb-4 d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por empresa o RTN..." value="{{ $buscar ?? '' }}">
                <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-search"></i> Buscar</button>
            </form>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>RTN</th>
                            <th>Empresa</th>
                            <th>Contacto</th>
                            <th>Categoría</th>
                            <th>Límite / Días</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proveedores as $proveedor)
                            <tr>
                                <td><strong>{{ $proveedor->rtn }}</strong></td>
                                <td>{{ $proveedor->empresa }}</td>
                                <td>
                                    {{ $proveedor->contacto }}<br>
                                    <small class="text-muted"><i class="bi bi-telephone"></i> {{ $proveedor->telefono }}</small>
                                </td>
                                <td>{{ $proveedor->categoria }}</td>
                                <td>
                                    L. {{ number_format($proveedor->limite_credito, 2) }}<br>
                                    <span class="badge bg-secondary">{{ $proveedor->dias_credito }} días</span>
                                </td>
                                <td>
                                    <!-- Badge de Estado -->
                                    @if($proveedor->estado == 'Activo')
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-editar" 
                                        data-id="{{ $proveedor->id }}"
                                        data-rtn="{{ $proveedor->rtn }}"
                                        data-empresa="{{ $proveedor->empresa }}"
                                        data-telefono="{{ $proveedor->telefono }}"
                                        data-contacto="{{ $proveedor->contacto }}"
                                        data-categoria="{{ $proveedor->categoria }}"
                                        data-limite="{{ $proveedor->limite_credito }}"
                                        data-dias="{{ $proveedor->dias_credito }}"
                                        data-estado="{{ $proveedor->estado }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este proveedor permanentemente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No hay proveedores registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $proveedores->links() }}
            </div>
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

  <!-- MODAL DINÁMICO (Crear/Editar) -->
  <div class="modal fade" id="modalProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1a432b; color: white;">
          <h5 class="modal-title" id="modalTituloProveedor">Registrar Proveedor</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        
        <form id="formProveedor" action="{{ route('proveedores.store') }}" method="POST">
          @csrf
          <div id="metodoDinamicoProveedor"></div>
          
          <div class="modal-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">RTN (14 dígitos) <span class="text-danger">*</span></label>
                <input type="text" name="rtn" id="input-rtn" class="form-control" maxlength="14" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Empresa (Razón Social) <span class="text-danger">*</span></label>
                <input type="text" name="empresa" id="input-empresa" class="form-control" required>
              </div>
              
              <div class="col-md-6">
                <label class="form-label">Teléfono (8 dígitos) <span class="text-danger">*</span></label>
                <input type="text" name="telefono" id="input-telefono" class="form-control" maxlength="8" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Contacto (Asesor) <span class="text-danger">*</span></label>
                <input type="text" name="contacto" id="input-contacto" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Categoría <span class="text-danger">*</span></label>
                <select name="categoria" id="input-categoria" class="form-select" required>
                  <option value="">Seleccione...</option>
                  <option value="Fármacos">Fármacos</option>
                  <option value="Material Quirúrgico">Material Quirúrgico</option>
                  <option value="Equipos">Equipos</option>
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
                <label class="form-label">Límite de Crédito (L.) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="limite_credito" id="input-limite" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Días de Crédito <span class="text-danger">*</span></label>
                <select name="dias_credito" id="input-dias" class="form-select" required>
                  <option value="">Seleccione...</option>
                  <option value="15">15 días</option>
                  <option value="30">30 días</option>
                  <option value="45">45 días</option>
                  <option value="60">60 días</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" id="btn-submit-proveedor" class="btn btn-success" style="background-color: #1a432b; border-color: #1a432b;">Guardar Proveedor</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  
  <script>
  document.addEventListener("DOMContentLoaded", function() {
      const form = document.getElementById('formProveedor');
      const modalTitulo = document.getElementById('modalTituloProveedor');
      const btnSubmit = document.getElementById('btn-submit-proveedor');
      const metodoDinamico = document.getElementById('metodoDinamicoProveedor');

      // Configurar botón Nuevo
      document.getElementById('btn-nuevo-proveedor').addEventListener('click', function() {
          form.reset();
          form.action = "{{ route('proveedores.store') }}";
          modalTitulo.textContent = 'Registrar Nuevo Proveedor';
          btnSubmit.textContent = 'Guardar Proveedor';
          metodoDinamico.innerHTML = '';
      });

      // Configurar botones Editar
      document.querySelectorAll('.btn-editar').forEach(button => {
          button.addEventListener('click', function() {
              const id = this.getAttribute('data-id');
              
              document.getElementById('input-rtn').value = this.getAttribute('data-rtn');
              document.getElementById('input-empresa').value = this.getAttribute('data-empresa');
              document.getElementById('input-telefono').value = this.getAttribute('data-telefono');
              document.getElementById('input-contacto').value = this.getAttribute('data-contacto');
              document.getElementById('input-categoria').value = this.getAttribute('data-categoria');
              document.getElementById('input-limite').value = this.getAttribute('data-limite');
              document.getElementById('input-dias').value = this.getAttribute('data-dias');
              document.getElementById('input-estado').value = this.getAttribute('data-estado');
              
              form.action = `/proveedores/${id}`;
              modalTitulo.textContent = 'Editar Proveedor';
              btnSubmit.textContent = 'Actualizar Proveedor';
              metodoDinamico.innerHTML = '@method("PUT")';

              var myModal = new bootstrap.Modal(document.getElementById('modalProveedor'));
              myModal.show();
          });
      });
  });
  </script>
</body>
</html>