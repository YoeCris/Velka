<?php

namespace App\Livewire\Comuneros;

use App\Models\Comunero;
use App\Models\Sector;
use App\Services\PadronPdfService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    // Filtros
    public $search = '';
    public $filtroSector = '';
    public $filtroCondicion = '';
    public $filtroActivo = '';

    // Modal
    public $showModal = false;
    public $comuneroId = null;

    // Modal de confirmación para eliminar
    public $showDeleteModal = false;
    public $comuneroToDelete = null;
    public $comuneroToDeleteName = '';

    // Form data
    public $form = [
        'dni' => '',
        'nombres' => '',
        'apellidos' => '',
        'genero' => '',
        'fecha_nacimiento' => '',
        'telefono' => '',
        'direccion' => '',
        'estado_civil' => '',
        'condicion' => 'no_calificado',
        'sector_id' => '',
        'fecha_ingreso' => '',
        'observaciones' => '',
        'activo' => true
    ];

    protected $listeners = [
        'comuneroEliminado' => '$refresh',
        'comuneroActualizado' => '$refresh'
    ];

    public function mount()
    {
        $this->authorize('viewAny', Comunero::class);
        
        // Si es admin sector, filtrar por su sector automáticamente
        if (auth()->user()->isAdminSector()) {
            $this->filtroSector = auth()->user()->sector_id;
        }
    }

    public function rules()
    {
        $rules = [
            'form.dni' => 'required|string|size:8|unique:comuneros,dni' . ($this->comuneroId ? ",{$this->comuneroId}" : ''),
            'form.nombres' => 'required|string|max:100',
            'form.apellidos' => 'required|string|max:100',
            'form.genero' => 'required|in:masculino,femenino',
            'form.fecha_nacimiento' => 'required|date|before:today',
            'form.telefono' => 'nullable|string|max:20',
            'form.direccion' => 'nullable|string',
            'form.estado_civil' => 'required|in:soltero,casado,conviviente,divorciado,viudo',
            'form.condicion' => 'required|in:calificado,no_calificado',
            'form.sector_id' => 'required|exists:sectores,id',
            'form.fecha_ingreso' => 'required|date',
            'form.observaciones' => 'nullable|string',
            'form.activo' => 'boolean'
        ];

        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFiltroSector()
    {
        $this->resetPage();
    }

    public function updatingFiltroCondicion()
    {
        $this->resetPage();
    }

    public function updatingFiltroActivo()
    {
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->search = '';
        $this->filtroCondicion = '';
        $this->filtroActivo = '';
        
        // No limpiar filtroSector si es admin_sector
        if (auth()->user()->isSuperadmin()) {
            $this->filtroSector = '';
        }
        
        $this->resetPage();
    }

    public function editarComunero($id)
    {
        $this->authorize('update', Comunero::findOrFail($id));
        
        $comunero = Comunero::findOrFail($id);
        $this->comuneroId = $id;
        $this->form = [
            'dni' => $comunero->dni,
            'nombres' => $comunero->nombres,
            'apellidos' => $comunero->apellidos,
            'genero' => $comunero->genero,
            'fecha_nacimiento' => $comunero->fecha_nacimiento->format('Y-m-d'),
            'telefono' => $comunero->telefono,
            'direccion' => $comunero->direccion,
            'estado_civil' => $comunero->estado_civil,
            'condicion' => $comunero->condicion,
            'sector_id' => $comunero->sector_id,
            'fecha_ingreso' => $comunero->fecha_ingreso->format('Y-m-d'),
            'observaciones' => $comunero->observaciones,
            'activo' => $comunero->activo
        ];
        $this->showModal = true;
    }

    public function guardarComunero()
    {
        if ($this->comuneroId) {
            $this->authorize('update', Comunero::findOrFail($this->comuneroId));
        } else {
            $this->authorize('create', Comunero::class);
        }

        $this->validate();

        if ($this->comuneroId) {
            // Actualizar
            $comunero = Comunero::findOrFail($this->comuneroId);
            $comunero->update($this->form);
            
            session()->flash('message', 'Comunero actualizado exitosamente.');
        } else {
            // Crear
            Comunero::create($this->form);
            session()->flash('message', 'Comunero creado exitosamente.');
        }

        $this->cerrarModal();
    }

    /**
     * Preparar la confirmación de eliminación
     */
    public function confirmarEliminacion($id)
    {
        $this->authorize('delete', Comunero::findOrFail($id));
        
        $comunero = Comunero::findOrFail($id);
        $this->comuneroToDelete = $id;
        $this->comuneroToDeleteName = $comunero->nombre_completo;
        $this->showDeleteModal = true;
    }

    /**
     * Eliminar el comunero después de la confirmación
     */
    public function eliminarComunero()
    {
        if (!$this->comuneroToDelete) {
            return;
        }

        $this->authorize('delete', Comunero::findOrFail($this->comuneroToDelete));
        
        try {
            $comunero = Comunero::findOrFail($this->comuneroToDelete);
            $nombreComunero = $comunero->nombre_completo;
            
            $comunero->delete(); // Soft delete
            
            // Limpiar variables del modal
            $this->comuneroToDelete = null;
            $this->comuneroToDeleteName = '';
            $this->showDeleteModal = false;
            
            session()->flash('message', "Comunero {$nombreComunero} eliminado exitosamente.");
            $this->dispatch('comuneroEliminado');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el comunero. Intente nuevamente.');
            $this->cerrarModalEliminar();
        }
    }

    /**
     * Cerrar modal de confirmación de eliminación
     */
    public function cerrarModalEliminar()
    {
        $this->showDeleteModal = false;
        $this->comuneroToDelete = null;
        $this->comuneroToDeleteName = '';
    }

    public function exportarPDF()
    {
        $this->authorize('exportPadron', [Comunero::class, $this->getSectorFiltro()]);
        
        $query = $this->getComunerosQuery();
        $comuneros = $query->get();
        
        $filtros = [
            'buscar' => $this->search,
            'sector' => $this->getSectorNombre(),
            'condicion' => $this->filtroCondicion,
            'activo' => $this->filtroActivo !== '' ? (bool)$this->filtroActivo : null
        ];
        
        $pdfService = new PadronPdfService();
        $resultado = $pdfService->generarPadronPdf($comuneros, $filtros, auth()->id());
        
        return response()->download(
            storage_path('app/public/' . $resultado['ruta']),
            $resultado['nombre']
        );
    }

    public function cerrarModal()
    {
        $this->showModal = false;
        $this->comuneroId = null;
        $this->form = [
            'dni' => '',
            'nombres' => '',
            'apellidos' => '',
            'genero' => '',
            'fecha_nacimiento' => '',
            'telefono' => '',
            'direccion' => '',
            'estado_civil' => '',
            'condicion' => 'no_calificado',
            'sector_id' => '',
            'fecha_ingreso' => '',
            'observaciones' => '',
            'activo' => true
        ];
        $this->resetValidation();
    }

    public function getSectorFiltro()
    {
        return $this->filtroSector ? (int)$this->filtroSector : null;
    }

    private function getSectorNombre()
    {
        if ($this->filtroSector) {
            $sector = Sector::find($this->filtroSector);
            return $sector ? $sector->nombre : null;
        }
        return null;
    }

    private function getComunerosQuery()
    {
        $query = Comunero::with('sector');

        // Filtrar por sector según permisos
        if (auth()->user()->isAdminSector()) {
            $query->where('sector_id', auth()->user()->sector_id);
        } elseif ($this->filtroSector) {
            $query->where('sector_id', $this->filtroSector);
        }

        // Aplicar filtros
        if ($this->search) {
            $query->buscarPorDniONombre($this->search);
        }

        if ($this->filtroCondicion) {
            $query->where('condicion', $this->filtroCondicion);
        }

        if ($this->filtroActivo !== '') {
            $query->where('activo', (bool)$this->filtroActivo);
        }

        return $query->orderBy('apellidos')->orderBy('nombres');
    }

    public function render()
    {
        $comuneros = $this->getComunerosQuery()->paginate(15);
        
        $sectoresQuery = Sector::activos();
        
        // Si es admin sector, solo mostrar su sector
        if (auth()->user()->isAdminSector()) {
            $sectoresQuery->where('id', auth()->user()->sector_id);
        }
        
        $sectores = $sectoresQuery->get();

        return view('livewire.comuneros.index', [
            'comuneros' => $comuneros,
            'sectores' => $sectores
        ])->layout('components.layouts.app');
    }
}
