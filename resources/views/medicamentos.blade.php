<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medicamentos - DISFARMA</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">

  <!-- Local Third-Party Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/apexcharts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

  <!-- Main Design System & Custom Stylesheet -->
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body>

  <!-- ==========================================
         START: Sidebar Component
         ========================================== -->
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
            <a href="{{ route('dashboard') }}" class="sidebar-menu-link" id="menu-overview" title="Overview">
              <i class="bi bi-grid-fill"></i>
              <span>Dashboard</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">Medicamentos</div>
        <ul class="sidebar-menu-list">
          <li class="sidebar-menu-item">
            <a href="{{ route('medicamentos.index') }}" class="sidebar-menu-link active" title="Catálogo">
              <i class="bi bi-capsule"></i>
              <span>Catálogo</span>
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

    <!-- Sidebar Profile Card -->
    <div class="sidebar-profile">
      <img src="{{ asset('assets/images/avatar.png') }}" alt="Administrator" class="sidebar-profile-img"
        onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop'">
      <div class="sidebar-profile-info">
        <div class="sidebar-profile-name">{{ Auth::user()->usuario ?? 'Admin' }}</div>
        <div class="sidebar-profile-email">admin@email.com</div>
      </div>
    </div>
  </div>
  <!-- END: Sidebar Component -->


  <!-- ==========================================
         START: Main Content Area
         ========================================== -->
  <div class="main-wrapper">

    <!-- START: Top Navbar Component -->
    <header class="navbar-custom">
      <div class="navbar-left">
        <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3" id="desktop-sidebar-toggle">
          <i class="bi bi-chevron-bar-left"></i>
        </button>
        <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
          <i class="bi bi-list"></i>
        </button>
      </div>

      <div class="navbar-actions">
        <div class="dropdown ms-2">
          <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('assets/images/avatar.png') }}" alt="Profile Image" class="navbar-profile-img">
            <span class="navbar-profile-name d-none d-md-inline">{{ Auth::user()->usuario ?? 'Admin' }}</span>
            <i class="bi bi-chevron-down navbar-profile-caret"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile">
            <li class="dropdown-header">Menu</li>
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
            <h1 class="page-title">Catalogo de Medicamentos</h1>
            <p class="page-subtitle">Gestión de inventario</p>
        </div>
        <button type="button" class="btn btn-success" style="background-color: #1a432b; border-color: #1a432b;" data-bs-toggle="modal" data-bs-target="#modalCrearMedicamento">
            <i class="bi bi-plus-lg"></i> Nuevo Medicamento
        </button>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-stat mt-4 mb-4">
        <div class="card-body">
            <!-- Buscador -->
            <form action="{{ route('medicamentos.index') }}" method="GET" class="mb-4 d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre o código SKU..." value="{{ $buscar ?? '' }}">
                <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-search"></i> Buscar</button>
                @if($buscar)
                    <a href="{{ route('medicamentos.index') }}" class="btn btn-outline-danger ms-2">Limpiar</a>
                @endif
            </form>

            <!-- Tabla Responsiva -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Imagen</th>
                            <th>Código (SKU)</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Vencimiento</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medicamentos as $medicamento)
                            <tr>
                                <td>
                                    @if($medicamento->imagen)
                                        <img src="{{ asset('storage/' . $medicamento->imagen) }}" alt="{{ $medicamento->nombreMedicamento }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <span class="text-muted"><i class="bi bi-image fs-4"></i></span>
                                    @endif
                                </td>
                                <td><strong>{{ $medicamento->codigo }}</strong></td>
                                <td>{{ $medicamento->nombreMedicamento }}</td>
                                <td>{{ $medicamento->categoria }}</td>
                                <td>L. {{ number_format($medicamento->precio, 2) }}</td>
                                <td>
                                    <!-- Badges Semánticos de Stock -->
                                    @if($medicamento->inventario >= 20)
                                        <span class="badge bg-success">{{ $medicamento->inventario }} - Óptimo</span>
                                    @elseif($medicamento->inventario >= 10)
                                        <span class="badge bg-warning text-dark">{{ $medicamento->inventario }} - Moderado</span>
                                    @else
                                        <span class="badge bg-danger">{{ $medicamento->inventario }} - ¡Desabastecimiento!</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($medicamento->vencimiento)->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditarMedicamento{{ $medicamento->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('medicamentos.destroy', $medicamento->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este medicamento? Esta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">No se encontraron medicamentos en el inventario.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $medicamentos->links() }}
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

    <div class="modal fade" id="modalCrearMedicamento" tabindex="-1" aria-labelledby="modalCrearMedicamentoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header" style="background-color: #1a432b; color: white;">
            <h5 class="modal-title" id="modalCrearMedicamentoLabel"><i class="bi bi-capsule me-2"></i> Registrar Nuevo Medicamento</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('medicamentos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                <label class="form-label">Código (SKU) <span class="text-danger">*</span></label>
                <input type="text" name="codigo" class="form-control" value="{{ old('codigo') }}" required>
                </div>
                <div class="col-md-6">
                <label class="form-label">Nombre del Medicamento <span class="text-danger">*</span></label>
                <input type="text" name="nombreMedicamento" class="form-control" value="{{ old('nombreMedicamento') }}" required>
                </div>
                
                <div class="col-md-6">
                <label class="form-label">Categoría <span class="text-danger">*</span></label>
                <select name="categoria" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <option value="Antibióticos" {{ old('categoria') == 'Antibióticos' ? 'selected' : '' }}>Antibióticos</option>
                    <option value="Analgésicos" {{ old('categoria') == 'Analgésicos' ? 'selected' : '' }}>Analgésicos</option>
                    <option value="Sueros" {{ old('categoria') == 'Sueros' ? 'selected' : '' }}>Sueros</option>
                    <option value="Material Quirúrgico" {{ old('categoria') == 'Material Quirúrgico' ? 'selected' : '' }}>Material Quirúrgico</option>
                    <option value="Vitaminas" {{ old('categoria') == 'Vitaminas' ? 'selected' : '' }}>Vitaminas</option>
                </select>
                </div>
                <div class="col-md-6">
                <label class="form-label">Laboratorio <span class="text-danger">*</span></label>
                <input type="text" name="laboratorio" class="form-control" value="{{ old('laboratorio') }}" required>
                </div>

                <div class="col-md-4">
                <label class="form-label">Precio (L.) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio') }}" required>
                </div>
                <div class="col-md-4">
                <label class="form-label">Costo (L.) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="costo" class="form-control" value="{{ old('costo') }}" required>
                </div>
                <div class="col-md-4">
                <label class="form-label">Inventario (Stock) <span class="text-danger">*</span></label>
                <input type="number" name="inventario" class="form-control" value="{{ old('inventario') }}" required>
                </div>

                <div class="col-md-6">
                <label class="form-label">Número de Lote <span class="text-danger">*</span></label>
                <input type="text" name="numero_lote" class="form-control" value="{{ old('numero_lote') }}" required>
                </div>
                <div class="col-md-6">
                <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
                <input type="date" name="vencimiento" class="form-control" value="{{ old('vencimiento') }}" required>
                </div>

                <div class="col-12">
                <label class="form-label">Imagen del Empaque (Max 5MB)</label>
                <input type="file" name="imagen" class="form-control" accept="image/jpeg, image/png, image/webp">
                </div>
            </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success" style="background-color: #1a432b; border-color: #1a432b;">Guardar Medicamento</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    
    @foreach($medicamentos as $medicamento)
    <div class="modal fade" id="modalEditarMedicamento{{ $medicamento->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header" style="background-color: #1a432b; color: white;">
            <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i> Editar: {{ $medicamento->nombreMedicamento }}</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <form action="{{ route('medicamentos.update', $medicamento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 
            
            <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                <label class="form-label">Código (SKU) <span class="text-danger">*</span></label>
                <input type="text" name="codigo" class="form-control" value="{{ $medicamento->codigo }}" required>
                </div>
                <div class="col-md-6">
                <label class="form-label">Nombre del Medicamento <span class="text-danger">*</span></label>
                <input type="text" name="nombreMedicamento" class="form-control" value="{{ $medicamento->nombreMedicamento }}" required>
                </div>
                
                <div class="col-md-6">
                <label class="form-label">Categoría <span class="text-danger">*</span></label>
                <select name="categoria" class="form-select" required>
                    <option value="Antibióticos" {{ $medicamento->categoria == 'Antibióticos' ? 'selected' : '' }}>Antibióticos</option>
                    <option value="Analgésicos" {{ $medicamento->categoria == 'Analgésicos' ? 'selected' : '' }}>Analgésicos</option>
                    <option value="Sueros" {{ $medicamento->categoria == 'Sueros' ? 'selected' : '' }}>Sueros</option>
                    <option value="Material Quirúrgico" {{ $medicamento->categoria == 'Material Quirúrgico' ? 'selected' : '' }}>Material Quirúrgico</option>
                    <option value="Vitaminas" {{ $medicamento->categoria == 'Vitaminas' ? 'selected' : '' }}>Vitaminas</option>
                </select>
                </div>
                <div class="col-md-6">
                <label class="form-label">Laboratorio <span class="text-danger">*</span></label>
                <input type="text" name="laboratorio" class="form-control" value="{{ $medicamento->laboratorio }}" required>
                </div>

                <div class="col-md-4">
                <label class="form-label">Precio (L.) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="precio" class="form-control" value="{{ $medicamento->precio }}" required>
                </div>
                <div class="col-md-4">
                <label class="form-label">Costo (L.) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="costo" class="form-control" value="{{ $medicamento->costo }}" required>
                </div>
                <div class="col-md-4">
                <label class="form-label">Inventario <span class="text-danger">*</span></label>
                <input type="number" name="inventario" class="form-control" value="{{ $medicamento->inventario }}" required>
                </div>

                <div class="col-md-6">
                <label class="form-label">Número de Lote <span class="text-danger">*</span></label>
                <input type="text" name="numero_lote" class="form-control" value="{{ $medicamento->numero_lote }}" required>
                </div>
                <div class="col-md-6">
                <label class="form-label">Vencimiento <span class="text-danger">*</span></label>
                <input type="date" name="vencimiento" class="form-control" value="{{ $medicamento->vencimiento }}" required>
                </div>

                <div class="col-12">
                <label class="form-label">Imagen (Dejar vacío para conservar la actual)</label>
                <input type="file" name="imagen" class="form-control" accept="image/jpeg, image/png, image/webp">
                @if($medicamento->imagen)
                    <small class="text-muted d-block mt-1">Imagen actual: <a href="{{ asset('storage/' . $medicamento->imagen) }}" target="_blank">Ver foto</a></small>
                @endif
                </div>
            </div>
            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success" style="background-color: #1a432b; border-color: #1a432b;">Actualizar Medicamento</button>
            </div>
        </form>
        </div>
    </div>
    @endforeach
    </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>