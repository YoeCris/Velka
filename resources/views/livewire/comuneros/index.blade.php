{{-- CONTENIDO PRINCIPAL CON PADDING --}}
<div class="px-6 py-8">
    {{-- Panel de filtros corregido - TODO EN UNA SOLA FILA --}}
    <div class="bg-gradient-to-r from-white via-blue-50/50 to-indigo-50/50 rounded-2xl shadow-lg border border-blue-100 p-6 mb-8">
        {{-- Header compacto --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">

            {{-- Título --}}
            <div class="flex items-center space-x-3">
                <div class="flex space-x-1">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse delay-75"></div>
                    <div class="w-2 h-2 bg-purple-500 rounded-full animate-pulse delay-150"></div>
                </div>
                <h2 class="text-4xl font-bold text-gray-900">Filtros de Búsqueda</h2>
            </div>

            {{-- Comuneros + Limpiar + Agregar --}}
            <div class="flex flex-wrap gap-2 justify-end">
                {{-- Contador --}}
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full border border-blue-200">
                    <span class="text-sm font-bold">{{ $comuneros->total() }}</span>
                    <span class="text-xs ml-1">comuneros</span>
                </div>
                
                {{-- Botón limpiar --}}
                <button 
                    wire:click="limpiarFiltros" 
                    class="flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white 
                        rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581
                                m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Limpiar
                </button>

                {{-- Botón agregar --}}
                <button 
                    wire:click="showModal"
                    class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white 
                        rounded-lg text-sm font-medium transition-transform hover:scale-105 shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 4v16m8-8H4"/>
                    </svg>
                    Agregar Comunero
                </button>
            </div>
        </div>



        
        {{-- FILTROS RESPONSIVOS AUTOMÁTICOS --}}
        <div class="grid gap-4" 
            style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">

            {{-- BÚSQUEDA --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <div>
                    <input 
                        wire:model.live="search" 
                        type="text" 
                        placeholder="DNI o nombre..."
                        class="w-full h-11 border-2 border-gray-200 hover:border-blue-300 focus:border-blue-500 
                            rounded-lg px-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                </div>
            </div>

            {{-- SECTOR --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                <select 
                    wire:model.live="filtroSector" 
                    class="w-full h-11 border-2 border-gray-200 hover:border-green-300 focus:border-green-500 
                        rounded-lg px-3 text-sm focus:ring-2 focus:ring-green-500 transition-all">
                    <option value="">Todos</option>
                    @foreach($sectores as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- CONDICIÓN --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Condición</label>
                <select 
                    wire:model.live="filtroCondicion" 
                    class="w-full h-11 border-2 border-gray-200 hover:border-purple-300 focus:border-purple-500 
                        rounded-lg px-3 text-sm focus:ring-2 focus:ring-purple-500 transition-all">
                    <option value="">Todas</option>
                    <option value="calificado">✅ Calificado</option>
                    <option value="no_calificado">⚠️ No Calificado</option>
                </select>
            </div>

            {{-- ESTADO --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select 
                    wire:model.live="filtroActivo" 
                    class="w-full h-11 border-2 border-gray-200 hover:border-amber-300 focus:border-amber-500 
                        rounded-lg px-3 text-sm focus:ring-2 focus:ring-amber-500 transition-all">
                    <option value="">Todos</option>
                    <option value="1">🟢 Activos</option>
                    <option value="0">⚪ Inactivos</option>
                </select>
            </div>

            {{-- BOTONES --}}
            <div class="flex gap-2">
                @can('exportPadron', [App\Models\Comunero::class, $this->getSectorFiltro()])
                <button 
                    wire:click="exportarPDF" 
                    class="flex-1 h-11 flex items-center justify-center bg-green-600 hover:bg-green-700 
                        text-white rounded-lg text-xl font-medium transition-all transform hover:scale-105 shadow-md">
                    PDF
                </button>
                @endcan

                <button 
                    class="flex-1 h-11 flex items-center justify-center bg-blue-600 hover:bg-blue-700 
                        text-white rounded-lg text-xl font-medium transition-all transform hover:scale-105 shadow-md">
                    Stats
                </button>
            </div>
        </div>




    </div>

    {{-- Tabla mejorada con pantalla completa --}}
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
        
        {{-- Paginación mejorada --}}
        @if($comuneros->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $comuneros->links() }}
        </div>
        @endif
    </div>
</div>