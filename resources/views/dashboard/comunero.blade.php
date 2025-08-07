<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi Panel - Comunidad de Jatucani
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Bienvenida Personal -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold">¡Bienvenido, {{ $user->nombre_completo }}!</h3>
                    <p class="mt-2 text-green-100">Panel personal del comunero</p>
                    <div class="mt-4 flex flex-wrap items-center gap-4 text-sm">
                        <span class="bg-green-400 bg-opacity-50 px-3 py-1 rounded-full">{{ $user->descripcion_sector }}</span>
                        <span class="bg-blue-400 bg-opacity-50 px-3 py-1 rounded-full">{{ $user->descripcion_condicion }}</span>
                        @if($user->ocupacion)
                            <span class="bg-yellow-400 bg-opacity-50 px-3 py-1 rounded-full">{{ $user->ocupacion }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información Personal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Mi Información Personal</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Información Básica</h4>
                            <div class="space-y-2 text-sm">
                                <div><span class="font-medium">DNI:</span> {{ $user->dni }}</div>
                                <div><span class="font-medium">Email:</span> {{ $user->email }}</div>
                                <div><span class="font-medium">Teléfono:</span> {{ $user->telefono ?: 'No registrado' }}</div>
                                <div><span class="font-medium">Fecha Nacimiento:</span> {{ $user->fecha_nacimiento ? $user->fecha_nacimiento->format('d/m/Y') : 'No registrado' }}</div>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Información de la Comunidad</h4>
                            <div class="space-y-2 text-sm">
                                <div><span class="font-medium">Sector:</span> {{ $user->descripcion_sector }}</div>
                                <div><span class="font-medium">Condición:</span> 
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $user->condicion === 'calificado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $user->descripcion_condicion }}
                                    </span>
                                </div>
                                <div><span class="font-medium">Ingreso a la Comunidad:</span> {{ $user->fecha_ingreso_comunidad ? $user->fecha_ingreso_comunidad->format('d/m/Y') : 'No registrado' }}</div>
                                <div><span class="font-medium">Estado:</span> 
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Información Adicional</h4>
                            <div class="space-y-2 text-sm">
                                <div><span class="font-medium">Ocupación:</span> {{ $user->ocupacion ?: 'No especificado' }}</div>
                                <div><span class="font-medium">Estado Civil:</span> {{ ucfirst($user->estado_civil) ?: 'No especificado' }}</div>
                                <div><span class="font-medium">Dirección:</span> {{ $user->direccion ?: 'No registrado' }}</div>
                                <div><span class="font-medium">Género:</span> {{ ucfirst($user->genero) ?: 'No especificado' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas para Comunero -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Acciones Disponibles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('profile') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition-colors">
                            <svg class="h-8 w-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h4 class="font-medium">Actualizar Perfil</h4>
                            <p class="text-sm opacity-90 mt-1">Editar información personal</p>
                        </a>
                        
                        <div class="bg-gray-300 p-4 rounded-lg text-center text-gray-600 cursor-not-allowed">
                            <svg class="h-8 w-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h4 class="font-medium">Solicitudes</h4>
                            <p class="text-sm opacity-70 mt-1">Próximamente disponible</p>
                        </div>
                        
                        <div class="bg-gray-300 p-4 rounded-lg text-center text-gray-600 cursor-not-allowed">
                            <svg class="h-8 w-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-6m0 0V9h8v6H8z" />
                            </svg>
                            <h4 class="font-medium">Eventos</h4>
                            <p class="text-sm opacity-70 mt-1">Próximamente disponible</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la Condición -->
            @if($user->condicion === 'no_calificado')
            <div class="bg-yellow-50 border border-yellow-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-yellow-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-yellow-800">Comunero No Calificado</h3>
                            <p class="text-yellow-700 text-sm mt-1">
                                Actualmente tiene la condición de "No Calificado". Para obtener la calificación de comunero, debe cumplir con los requisitos establecidos por la comunidad y pasar por el proceso de evaluación correspondiente.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4 class="font-medium text-yellow-800 mb-2">Para obtener la calificación necesita:</h4>
                        <ul class="text-sm text-yellow-700 list-disc list-inside space-y-1">
                            <li>Haber residido en la comunidad por al menos 2 años</li>
                            <li>Participar activamente en las asambleas comunales</li>
                            <li>Cumplir con las faenas y trabajos comunales</li>
                            <li>No tener deudas pendientes con la comunidad</li>
                            <li>Presentar solicitud formal ante la junta directiva</li>
                        </ul>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-green-50 border border-green-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-green-800">¡Felicidades! Comunero Calificado</h3>
                            <p class="text-green-700 text-sm mt-1">
                                Tiene la condición de "Comunero Calificado", lo que le otorga todos los derechos y responsabilidades dentro de la comunidad, incluyendo voz y voto en las asambleas comunales.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4 class="font-medium text-green-800 mb-2">Sus derechos como comunero calificado:</h4>
                        <ul class="text-sm text-green-700 list-disc list-inside space-y-1">
                            <li>Participar con voz y voto en las asambleas</li>
                            <li>Elegir y ser elegido para cargos directivos</li>
                            <li>Acceso prioritario a programas comunales</li>
                            <li>Uso de recursos y espacios comunales</li>
                            <li>Representar a la comunidad en eventos externos</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Observaciones -->
            @if($user->observaciones)
            <div class="bg-blue-50 border border-blue-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-blue-800 mb-2">Observaciones</h3>
                    <p class="text-blue-700 text-sm">{{ $user->observaciones }}</p>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
