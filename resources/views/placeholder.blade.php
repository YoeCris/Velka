<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
        <div class="px-6 py-12">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                <div class="p-12 text-gray-900">
                    <div class="text-center">
                        <div class="mb-6">
                            <div class="mx-auto h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $title ?? 'Módulo en Desarrollo' }}</h2>
                        <p class="text-lg text-gray-600 mb-8">{{ $message ?? 'Esta funcionalidad estará disponible próximamente.' }}</p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Volver al Dashboard
                            </a>
                            
                            <div class="text-sm text-gray-500">
                                Funcionalidad en desarrollo...
                            </div>
                        </div>
                        
                        <!-- Información adicional -->
                        <div class="mt-12 bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Próximamente disponible</h3>
                            <p class="text-gray-600 text-sm">
                                Este módulo está siendo desarrollado para mejorar tu experiencia en el sistema.
                                Pronto podrás acceder a todas las funcionalidades relacionadas con {{ strtolower($title ?? 'este módulo') }}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
