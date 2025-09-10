<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <!-- Header con pantalla completa -->
    <div class="bg-white shadow-sm border-b border-gray-200 px-6 py-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-600 p-3 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Padrón Comunal</h1>
                    <p class="text-gray-600 mt-1">Gestión de comuneros de Jatucachi</p>
                </div>
            </div>
            
            @can('create', App\Models\Comunero::class)
            <button 
                wire:click="$set('showModal', true)" 
                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Comunero
            </button>
            @endcan
        </div>
    </div>

    <!-- Contenido principal - PANTALLA COMPLETA -->
    <div class="px-6 py-8">
        <!-- Filtros mejorados -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <div class="relative">
                        <input 
                            wire:model.live="search" 
                            type="text" 
                            placeholder="DNI o nombre..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sector</label>
                    <select wire:model.live="filtroSector" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos los sectores</option>
                        @foreach($sectores as $sector)
                            <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Condición</label>
                    <select wire:model.live="filtroCondicion" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todas</option>
                        <option value="calificado">Calificado</option>
                        <option value="no_calificado">No Calificado</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select wire:model.live="filtroActivo" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
                    </select>
                </div>
                
                <div class="flex flex-col justify-end">
                    <div class="flex gap-2">
                        @can('exportPadron', [App\Models\Comunero::class, $this->getSectorFiltro()])
                        <button 
                            wire:click="exportarPDF" 
                            class="flex items-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            PDF
                        </button>
                        @endcan
                        
                        <button 
                            wire:click="limpiarFiltros" 
                            class="flex items-center px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                <div class="text-sm text-gray-600 font-medium">
                    📊 {{ $comuneros->total() }} comuneros encontrados
                </div>
                <div class="text-xs text-gray-500">
                    Mostrando {{ $comuneros->firstItem() ?? 0 }} - {{ $comuneros->lastItem() ?? 0 }} de {{ $comuneros->total() }}
                </div>
            </div>
        </div>

        <!-- Tabla mejorada con pantalla completa -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                DNI
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Nombre Completo
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Sector
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Condición
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                % Asistencia
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Estado
                            </th>
                            @can('update', App\Models\Comunero::class)
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Acciones
                            </th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($comuneros as $comunero)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $comunero->dni }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <span class="text-sm font-bold text-blue-600">
                                            {{ strtoupper(substr($comunero->nombres, 0, 1) . substr($comunero->apellidos, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $comunero->nombre_completo }}</div>
                                        @if($comunero->telefono)
                                        <div class="text-sm text-gray-500">📞 {{ $comunero->telefono }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $comunero->sector->nombre }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $comunero->condicion === 'calificado' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $comunero->condicion === 'calificado' ? '✓ Calificado' : '⚠ No Calificado' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                                        <div class="bg-{{ $comunero->porcentaje_asistencia >= 50 ? 'green' : 'red' }}-500 h-2 rounded-full transition-all" style="width: {{ min(100, $comunero->porcentaje_asistencia) }}%"></div>
                                    </div>
                                    <span class="text-sm font-semibold">{{ number_format($comunero->porcentaje_asistencia, 1) }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $comunero->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $comunero->activo ? '✓ Activo' : '○ Inactivo' }}
                                </span>
                            </td>
                            @can('update', App\Models\Comunero::class)
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex gap-2">
                                    <button 
                                        wire:click="editarComunero({{ $comunero->id }})"
                                        class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>
                                    
                                    <button 
                                        wire:click="confirmarEliminacion({{ $comunero->id }})"
                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            @endcan
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->canModifyData() ? '7' : '6' }}" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-100 p-4 rounded-full mb-4">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900 mb-2">No se encontraron comuneros</p>
                                    <p class="text-sm text-gray-600">Intenta ajustar los filtros de búsqueda para encontrar resultados</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación mejorada -->
            @if($comuneros->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $comuneros->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Modal para crear/editar comunero -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="cerrarModal">
        <div class="relative top-10 mx-auto p-6 border w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/5 shadow-lg rounded-xl bg-white" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ $comuneroId ? 'Editar Comunero' : 'Nuevo Comunero' }}
                </h3>
                <button wire:click="cerrarModal" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form wire:submit="guardarComunero">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- DNI -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">DNI *</label>
                        <input 
                            wire:model="form.dni" 
                            type="text" 
                            maxlength="8"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.dni') border-red-500 @enderror">
                        @error('form.dni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Nombres -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                        <input 
                            wire:model="form.nombres" 
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.nombres') border-red-500 @enderror">
                        @error('form.nombres') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Apellidos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos *</label>
                        <input 
                            wire:model="form.apellidos" 
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.apellidos') border-red-500 @enderror">
                        @error('form.apellidos') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Género -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Género *</label>
                        <select 
                            wire:model="form.genero"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.genero') border-red-500 @enderror">
                            <option value="">Seleccionar</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                        </select>
                        @error('form.genero') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Fecha de Nacimiento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento *</label>
                        <input 
                            wire:model="form.fecha_nacimiento" 
                            type="date"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.fecha_nacimiento') border-red-500 @enderror">
                        @error('form.fecha_nacimiento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                        <input 
                            wire:model="form.telefono" 
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.telefono') border-red-500 @enderror">
                        @error('form.telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Estado Civil -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado Civil *</label>
                        <select 
                            wire:model="form.estado_civil"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.estado_civil') border-red-500 @enderror">
                            <option value="">Seleccionar</option>
                            <option value="soltero">Soltero</option>
                            <option value="casado">Casado</option>
                            <option value="conviviente">Conviviente</option>
                            <option value="divorciado">Divorciado</option>
                            <option value="viudo">Viudo</option>
                        </select>
                        @error('form.estado_civil') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Sector -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sector *</label>
                        <select 
                            wire:model="form.sector_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.sector_id') border-red-500 @enderror">
                            <option value="">Seleccionar sector</option>
                            @foreach($sectores as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                            @endforeach
                        </select>
                        @error('form.sector_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Fecha de Ingreso -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Ingreso *</label>
                        <input 
                            wire:model="form.fecha_ingreso" 
                            type="date"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.fecha_ingreso') border-red-500 @enderror">
                        @error('form.fecha_ingreso') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Condición -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Condición *</label>
                        <select 
                            wire:model="form.condicion"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.condicion') border-red-500 @enderror">
                            <option value="no_calificado">No Calificado</option>
                            <option value="calificado">Calificado</option>
                        </select>
                        @error('form.condicion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Estado Activo -->
                    <div class="flex items-center pt-8">
                        <input 
                            wire:model="form.activo" 
                            type="checkbox" 
                            id="activo"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="activo" class="ml-3 block text-sm font-medium text-gray-900">
                            Comunero activo
                        </label>
                    </div>
                </div>
                
                <!-- Dirección -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                    <textarea 
                        wire:model="form.direccion"
                        rows="2"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.direccion') border-red-500 @enderror"></textarea>
                    @error('form.direccion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Observaciones -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                    <textarea 
                        wire:model="form.observaciones"
                        rows="2"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('form.observaciones') border-red-500 @enderror"></textarea>
                    @error('form.observaciones') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Botones -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                    <button 
                        type="button"
                        wire:click="cerrarModal"
                        class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium transition-colors">
                        Cancelar
                    </button>
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        {{ $comuneroId ? 'Actualizar' : 'Crear' }} Comunero
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
