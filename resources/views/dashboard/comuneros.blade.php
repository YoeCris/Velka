<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Comuneros
            </h2>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm transition-colors">
                ← Volver al Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtros de Búsqueda</h3>
                    
                    <form method="GET" action="{{ route('dashboard.comuneros') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Búsqueda por texto -->
                            <div>
                                <label for="buscar" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                                <input type="text" 
                                       name="buscar" 
                                       id="buscar" 
                                       value="{{ request('buscar') }}"
                                       placeholder="Nombre, DNI, email..."
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Filtro por sector -->
                            <div>
                                <label for="sector" class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                                <select name="sector" id="sector" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Todos los sectores</option>
                                    <option value="sector_1" {{ request('sector') === 'sector_1' ? 'selected' : '' }}>Sector 1 - Centro</option>
                                    <option value="sector_2" {{ request('sector') === 'sector_2' ? 'selected' : '' }}>Sector 2 - Norte</option>
                                    <option value="sector_3" {{ request('sector') === 'sector_3' ? 'selected' : '' }}>Sector 3 - Sur</option>
                                    <option value="sector_4" {{ request('sector') === 'sector_4' ? 'selected' : '' }}>Sector 4 - Este</option>
                                </select>
                            </div>

                            <!-- Filtro por condición -->
                            <div>
                                <label for="condicion" class="block text-sm font-medium text-gray-700 mb-1">Condición</label>
                                <select name="condicion" id="condicion" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Todas las condiciones</option>
                                    <option value="calificado" {{ request('condicion') === 'calificado' ? 'selected' : '' }}>Calificado</option>
                                    <option value="no_calificado" {{ request('condicion') === 'no_calificado' ? 'selected' : '' }}>No Calificado</option>
                                </select>
                            </div>

                            <!-- Filtro por estado -->
                            <div>
                                <label for="activo" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                <select name="activo" id="activo" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activos</option>
                                    <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivos</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('dashboard.comuneros') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm transition-colors">
                                Limpiar Filtros
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm transition-colors">
                                Aplicar Filtros
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumen de resultados -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Lista de Comuneros 
                                <span class="text-gray-500 font-normal text-base">({{ $comuneros->total() }} total)</span>
                            </h3>
                        </div>
                        <div class="text-sm text-gray-600">
                            Mostrando {{ $comuneros->firstItem() }} - {{ $comuneros->lastItem() }} de {{ $comuneros->total() }} comuneros
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de comuneros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Comunero
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    DNI
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contacto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sector
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Condición
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ingreso
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($comuneros as $comunero)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ substr($comunero->name, 0, 1) }}{{ substr($comunero->apellido_paterno, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $comunero->nombre_completo }}</div>
                                            <div class="text-sm text-gray-500">{{ $comunero->ocupacion ?: 'Sin especificar' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $comunero->dni }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $comunero->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $comunero->telefono ?: 'Sin teléfono' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $comunero->descripcion_sector }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $comunero->condicion === 'calificado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $comunero->descripcion_condicion }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $comunero->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $comunero->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $comunero->fecha_ingreso_comunidad ? $comunero->fecha_ingreso_comunidad->format('d/m/Y') : 'No registrado' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                    <a href="#" class="text-green-600 hover:text-green-900">Editar</a>
                                    @if($comunero->condicion === 'no_calificado')
                                        <a href="#" class="text-blue-600 hover:text-blue-900">Calificar</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                        </svg>
                                        <p>No se encontraron comuneros con los criterios especificados</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($comuneros->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $comuneros->appends(request()->query())->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
