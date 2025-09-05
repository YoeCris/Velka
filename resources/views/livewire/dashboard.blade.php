<!-- Dashboard optimizado sin elementos innecesarios -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <!-- Contenido principal -->
    <!-- Dashboard optimizado sin elementos innecesarios -->
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
        <!-- Header corporativo simplificado -->
        <div class="bg-white shadow-sm border-b border-gray-200 px-6 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Panel de Control</h1>
                        <p class="text-gray-600 mt-1">Sistema de Gestión Comunal - Jatucachi</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-8">
            <!-- Estadísticas principales - Solo 4 tarjetas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Comuneros -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-2xl font-medium text-gray-500">Total Comuneros</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1 counter" data-target="{{ $estadisticasGenerales['total_comuneros'] }}">0</p>
                            </div>
                        </div>
                        <!-- Barra de progreso animada -->
                        <div class="mt-4 bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between text-2xl text-gray-600 mb-2">
                                <span>Progreso del padrón</span>
                                <span>100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-6">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-6 rounded-full progress-bar" data-width="100" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calificados -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="bg-emerald-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-2xl font-medium text-gray-500">Comuneros Calificados</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1 counter" data-target="{{ $estadisticasGenerales['comuneros_calificados'] }}">0</p>
                            </div>
                        </div>
                        <!-- Gráfico circular mini -->
                        <div class="mt-4 bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="text-2xl text-gray-600 mb-1">% de Calificados</div>
                                    <div class="text-2xl font-bold text-emerald-600">
                                        @php
                                            $total = $estadisticasGenerales['total_comuneros'];
                                            $calificados = $estadisticasGenerales['comuneros_calificados'];
                                            $porcentaje = $total > 0 ? round(($calificados / $total) * 100, 1) : 0;
                                        @endphp
                                        {{ $porcentaje }}%
                                    </div>
                                </div>
                                <div class="w-20 h-20">
                                    <canvas id="chartCalificados"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Calificados -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-2xl font-medium text-gray-500">Comuneros No Calificados</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1 counter" data-target="{{ $estadisticasGenerales['comuneros_no_calificados'] }}">0</p>
                            </div>
                        </div>
                        <!-- Gráfico circular mini -->
                        <div class="mt-4 bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="text-2xl text-gray-600 mb-1">% No Calificados</div>
                                    <div class="text-2xl font-bold text-blue-600">
                                        @php
                                            $total = $estadisticasGenerales['total_comuneros'];
                                            $noCalificados = $estadisticasGenerales['comuneros_no_calificados'];
                                            $porcentajeNo = $total > 0 ? round(($noCalificados / $total) * 100, 1) : 0;
                                        @endphp
                                        {{ $porcentajeNo }}%
                                    </div>
                                </div>
                                <div class="w-20 h-20">
                                    <canvas id="chartNoCalificados"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Proporción por Sectores -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="ml-4 flex-1">
                                <p class="text-2xl font-bold text-gray-500 mt-1">Distribución por Sectores</p>
                            </div>
                        </div>
                        <!-- Gráfico que ocupa todo el ancho -->
                        <div class="mt-4 bg-gray-50 rounded-lg p-3">
                            <canvas id="chartProporcionSectores" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Distribución de Comuneros por Sector - Cards con donut -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
                <div class="p-6">
                    <h3 class="text-3xl font-semibold text-gray-900 mb-6">Distribución de Comuneros</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($estadisticasPorSector as $s)
                            @php
                                $sector = (string)($s['sector'] ?? 'Sector');
                                $total = (int)($s['total'] ?? 0);
                                $cal = (int)($s['calificados'] ?? $s['cal'] ?? 0);
                                $nocalRaw = $s['no_calificados'] ?? $s['noCalificados'] ?? $s['noCalif'] ?? null;
                                $nocal = is_null($nocalRaw) ? max(0, $total - $cal) : (int)$nocalRaw;
                                
                                if ($cal < 0) $cal = 0;
                                if ($nocal < 0) $nocal = 0;
                                if ($total <= 0) {
                                    $total = $cal + $nocal;
                                }
                                
                                $pCal = $total > 0 ? round(($cal / $total) * 100) : 0;
                                $pNo = max(0, 100 - $pCal);
                                $slug = \Illuminate\Support\Str::slug($sector, '-');
                            @endphp
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-xl font-semibold text-gray-900 truncate">{{ $sector }}</h4>
                                    <span class="text-xl text-gray-500">{{ $total }} total</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <!-- Donut mini -->
                                    <div class="w-24 h-24">
                                        <canvas id="donut-dist-{{ $slug }}"></canvas>
                                    </div>
                                    <!-- Etiquetas compactas -->
                                    <div class="flex-1 space-y-2 text-xl text-gray-700">
                                        <div class="flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1">
                                                <span class="w-4 h-4 bg-green-500 rounded-full"></span>
                                                Calificados
                                            </span>
                                            <span class="font-semibold text-green-600">{{ $pCal }}% ({{ $cal }})</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1">
                                                <span class="w-4 h-4 bg-blue-600 rounded-full"></span>
                                                No calificados
                                            </span>
                                            <span class="font-semibold text-blue-600">{{ $pNo }}% ({{ $nocal }})</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Data para JS -->
                                <script type="application/json" id="data-donut-dist-{{ $slug }}">
                                    {!! json_encode([$cal, $nocal], JSON_UNESCAPED_UNICODE) !!}
                                </script>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Análisis de asistencia por sector -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                        <div>
                            <h3 class="text-3xl font-semibold text-gray-900">Análisis de Asistencia por Sector</h3>
                            <p class="text-2xl text-gray-500 mt-1">
                                @if($selectedReunion)
                                    @php
                                        $reunion = $reunionesDisponibles->find($selectedReunion);
                                    @endphp
                                    Asistencia para: {{ $reunion ? $reunion->titulo : 'Reunión seleccionada' }}
                                @else
                                    Asistencia General
                                @endif
                            </p>
                        </div>
                        <!-- Filtro de Reuniones -->
                        <div class="flex items-center gap-2">
                            <label for="reunion-filter" class="text-2xl font-medium text-gray-700">Filtrar por:</label>
                            <select wire:model.live="selectedReunion" id="reunion-filter" 
                                    class="px-3 py-2 border border-gray-300 rounded-lg text-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white min-w-[200px]"
                            >
                                <option value="">General</option>
                                @foreach($reunionesDisponibles as $reunion)
                                    <option value="{{ $reunion->id }}">
                                        {{ $reunion->titulo }} - {{ $reunion->fecha->format('d/m/Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @php
                        $labelsAsis = [];
                        $asisCal = [];
                        $asisNo = [];
                        
                        foreach ($tendenciaAsistenciaPorSector as $sec) {
                            $labelsAsis[] = (string)($sec['sector'] ?? 'Sector');
                            $pC = $sec['porcentaje_calificados'] ?? null;
                            $pNC = $sec['porcentaje_no_calificados'] ?? null;
                            
                            if (is_null($pC) || is_null($pNC)) {
                                $tc = (int)($sec['total_calificados'] ?? 0);
                                $tn = (int)($sec['total_no_calificados'] ?? 0);
                                $sum = max(1, $tc + $tn);
                                $pC = round(($tc / $sum) * 100, 2);
                                $pNC = round(($tn / $sum) * 100, 2);
                            } else {
                                $pC = max(0, (float)$pC);
                                $pNC = max(0, (float)$pNC);
                                $sum = max(1, $pC + $pNC);
                                $pC = round(($pC / $sum) * 100, 2);
                                $pNC = round(($pNC / $sum) * 100, 2);
                            }
                            
                            $asisCal[] = $pC;
                            $asisNo[] = $pNC;
                        }
                    @endphp

                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <canvas id="chartAsistenciaSectores" height="400"></canvas>
                    </div>
                </div>
            </div>

            <!-- Datos globales para el gráfico apilado 100% -->
            <script type="application/json" id="data-asis-sectores">
                {!! json_encode(['labels' => $labelsAsis, 'cal' => $asisCal, 'nocal' => $asisNo], JSON_UNESCAPED_UNICODE) !!}
            </script>

            <!-- Variable para actualizar el gráfico cuando cambie el filtro -->
            <script>
                // Función para actualizar datos del gráfico
                window.updateAsistenciaData = function() {
                    window.asistenciaData = {!! json_encode(['labels' => $labelsAsis, 'cal' => $asisCal, 'nocal' => $asisNo], JSON_UNESCAPED_UNICODE) !!};
                    // Agregar datos de totales para el tooltip
                    window.totalesPorSector = {
                        calificados: {!! json_encode(array_column($tendenciaAsistenciaPorSector, 'total_calificados')) !!},
                        no_calificados: {!! json_encode(array_column($tendenciaAsistenciaPorSector, 'total_no_calificados')) !!}
                    };
                };
                // Ejecutar por primera vez
                window.updateAsistenciaData();
            </script>

            <!-- Últimas reuniones -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Últimas Reuniones</h3>
                        @if(auth()->user()->isSuperadmin())
                            <a href="{{ route('reuniones.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Ver todas
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif
                    </div>

                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Reunión</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Asistencia</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($ultimasReuniones as $reunion)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900">{{ $reunion['titulo'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $reunion['fecha']->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $reunion['tipo'] === 'ordinaria' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                {{ ucfirst($reunion['tipo']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $reunion['estado'] === 'cerrada' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($reunion['estado']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                    <div class="bg-{{ $reunion['porcentaje_asistencia'] >= 70 ? 'green' : ($reunion['porcentaje_asistencia'] >= 50 ? 'yellow' : 'red') }}-500 h-2 rounded-full" style="width: {{ $reunion['porcentaje_asistencia'] }}%"></div>
                                                </div>
                                                <span class="text-sm font-semibold">{{ $reunion['porcentaje_asistencia'] }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="bg-gray-100 p-3 rounded-full mb-3">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-8 0h16m-16 0v1a3 3 0 003 3h10a3 3 0 003-3v-1M9 11l3 3 6-6"/>
                                                    </svg>
                                                </div>
                                                <p class="font-semibold text-gray-900">No hay reuniones registradas</p>
                                                <p class="text-sm text-gray-600">Las reuniones aparecerán aquí cuando se programen</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
    <script>
        /* ====== DEFAULTS GLOBALES PARA TIPOGRAFÍA DE GRÁFICOS ====== */
        Chart.defaults.font.size = 15; // tamaño base (ajústalo a 13–14 si quieres más grande)
        Chart.defaults.color = '#374151'; // Tailwind Gray 700

        /* ====== PLUGIN: % EN EL CENTRO DEL DONUT ====== */
        const DoughnutCenterText = {
            id: 'doughnutCenterText',
            afterDraw(chart, args, options) {
                if (chart.config?.type !== 'doughnut') return;
                const ds = chart.data.datasets?.[0];
                if (!ds) return;

                const total = (ds.data || []).reduce((a,b)=>a + (Number(b)||0), 0);
                const cal = Number(ds.data?.[0] || 0);
                const pct = total > 0 ? Math.round((cal/total)*100) : 0;

                const {ctx} = chart, meta = chart.getDatasetMeta(0);
                if (!meta?.data?.[0]) return;

                const {x, y} = meta.data[0];
                ctx.save();
                ctx.font = (options?.fontSize || 20) + 'px ' + (Chart.defaults.font.family || 'sans-serif');
                ctx.fillStyle = options?.color || '#0e121aff'; // Gray 900
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(pct + '%', x, y);
                ctx.restore();
            }
        };

        Chart.register(DoughnutCenterText);

        document.addEventListener('DOMContentLoaded', () => {
            /* ---- ANIMACIONES DE LAS TARJETAS ---- */
            // 1. Animación de contadores numericos
            function animateCounters() {
                const counters = document.querySelectorAll('.counter');
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    const increment = target / 50; // 50 pasos
                    let current = 0;

                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            counter.textContent = target;
                            clearInterval(timer);
                        } else {
                            counter.textContent = Math.floor(current);
                        }
                    }, 30);
                });
            }

            // 3. Gráficos circulares mini
            function createMiniChart() {
                // Gráfico de Calificados (Verde)
                const ctxCalificados = document.getElementById('chartCalificados');
                if (ctxCalificados) {
                    const total = {{ $estadisticasGenerales['total_comuneros'] }};
                    const calificados = {{ $estadisticasGenerales['comuneros_calificados'] }};
                    const porcentaje = total > 0 ? (calificados / total) * 100 : 0;

                    new Chart(ctxCalificados.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: [porcentaje, 100 - porcentaje],
                                backgroundColor: [
                                    '#10B981', // verde
                                    '#E5E7EB'  // gris
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            cutout: '60%',
                            plugins: {
                                legend: { display: false },
                                tooltip: { enabled: false }
                            },
                            animation: {
                                duration: 2000,
                                easing: 'easeOutBounce'
                            }
                        }
                    });
                }

                // Gráfico de No Calificados (Azul)
                const ctxNoCalificados = document.getElementById('chartNoCalificados');
                if (ctxNoCalificados) {
                    const total = {{ $estadisticasGenerales['total_comuneros'] }};
                    const noCalificados = {{ $estadisticasGenerales['comuneros_no_calificados'] }};
                    const porcentajeNo = total > 0 ? (noCalificados / total) * 100 : 0;

                    new Chart(ctxNoCalificados.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: [porcentajeNo, 100 - porcentajeNo],
                                backgroundColor: [
                                    '#3B82F6', // azul
                                    '#E5E7EB'  // gris
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            cutout: '60%',
                            plugins: {
                                legend: { display: false },
                                tooltip: { enabled: false }
                            },
                            animation: {
                                duration: 2000,
                                easing: 'easeOutBounce',
                                delay: 300 // Empezar un poco después del de calificados
                            }
                        }
                    });
                }
            }

            // 2. Animación de barras de progreso
            function animateProgressBars() {
                const progressBars = document.querySelectorAll('.progress-bar');
                progressBars.forEach(bar => {
                    const targetWidth = bar.getAttribute('data-width');
                    setTimeout(() => {
                        bar.style.width = targetWidth + '%';
                        bar.style.transition = 'width 1.5s ease-out';
                    }, 500);
                });
            }

            // Ejecutar todas las animaciones
            setTimeout(() => {
                animateCounters();
                animateProgressBars();
                createMiniChart();
            }, 300);

            /* ---- Gráfico de Barras Mini por Sectores en la cuarta tarjeta ---- */
            const proportionCtx = document.getElementById('chartProporcionSectores');
            if (proportionCtx) {
                // Datos de sectores desde PHP
                const sectoresData = @json($estadisticasPorSector);
                const labels = sectoresData.map(s => s.sector);
                const data = sectoresData.map(s => s.total);
                const colors = [
                    '#1E3A8A', // Azul marino profundo
                    '#2563EB', // Azul principal (corporativo)
                    '#3B82F6', // Azul medio
                    '#60A5FA', // Azul claro
                ];

                new Chart(proportionCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Comuneros',
                            data: data,
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 1,
                            borderRadius: 4,
                            borderSkipped: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 5,
                                bottom: 5
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: {
                                    font: { size: 11, weight: 'bold' },
                                    color: '#6B7280'
                                },
                                border: { display: false }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    lineWidth: 1
                                },
                                ticks: {
                                    font: { size: 10 },
                                    color: '#9CA3AF',
                                    stepSize: 1
                                },
                                border: { display: false }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                enabled: true,
                                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                                titleColor: '#F9FAFB',
                                bodyColor: '#F3F4F6',
                                borderColor: 'rgba(75, 85, 99, 0.8)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                padding: 10,
                                displayColors: true,
                                callbacks: {
                                    title: function(context) {
                                        return context[0].label;
                                    },
                                    label: function(context) {
                                        const total = data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((context.parsed.y / total) * 100).toFixed(1) : 0;
                                        return context.parsed.y + ' comuneros - ' + percentage + '% del total';
                                    },
                                    afterLabel: function() {
                                        return null; // No mostrar línea adicional
                                    }
                                }
                            }
                        }
                    }
                });
            }

            /* ---- Donuts de "Distribución de Comuneros" ---- */
            document.querySelectorAll('[id^="data-donut-dist-"]').forEach(el => {
                const id = el.id.replace('data-donut-dist-','');
                let data = [0,0];
                try {
                    data = JSON.parse(el.textContent || '[0,0]');
                } catch(e) {}

                const canvas = document.getElementById(`donut-dist-${id}`);
                if (!canvas) return;

                new Chart(canvas.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Calificados','No calificados'],
                        datasets: [{
                            data,
                            backgroundColor: [
                                'rgba(16,185,129,0.9)', // verde base (Calificados)
                                'rgba(28,75,230,0.9)'   // azul base (No calificados)
                            ],
                            borderWidth: 0,
                            hoverBackgroundColor: [
                                'rgba(6, 95, 70, 1)',    // verde hover más oscuro y fuerte
                                'rgba(30, 58, 138, 1)'   // azul hover más oscuro y saturado
                            ]
                        }]
                    },
                    options: {
                        cutout: '65%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                bodyFont: { size: 12 },
                                titleFont: { size: 12 }
                            },
                            doughnutCenterText: {
                                fontSize: 25,
                                color: '#111827'
                            }
                        }
                    }
                });
            });

            /* ---- Barras dobles comparativas de Asistencia por sector ---- */
            let asistenciaChart = null;

            function createAsistenciaChart() {
                const ctx = document.getElementById('chartAsistenciaSectores');
                if (!ctx) return;

                // Destruir gráfico existente si existe
                if (asistenciaChart) {
                    asistenciaChart.destroy();
                }

                const data = window.asistenciaData || {};

                asistenciaChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels || [],
                        datasets: [
                            {
                                label: 'Calificados',
                                data: data.cal || [],
                                backgroundColor: 'rgba(16,185,129,0.8)',
                                borderColor: 'rgba(0, 212, 142, 1)',
                                borderWidth: 1,
                                borderRadius: 4,
                                datalabels: { display: false }
                            },
                            {
                                label: 'No calificados',
                                data: data.nocal || [],
                                backgroundColor: 'rgba(28,75,230,0.9)',
                                borderColor: 'rgba(50, 98, 255, 1)',
                                borderWidth: 1,
                                borderRadius: 4,
                                datalabels: { display: false }
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: 0 },
                        animation: { duration: 800 },
                        elements: {
                            bar: { borderSkipped: false }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 12 } }
                            },
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: v => v + '%',
                                    font: { size: 12 }
                                },
                                grid: { color: 'rgba(0,0,0,0.1)' }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    font: { size: 12 },
                                    padding: 15
                                }
                            },
                            tooltip: {
                                enabled: true,
                                displayColors: true,
                                callbacks: {
                                    title: function(context) {
                                        const sectorNombre = context[0].label;
                                        return 'Sector ' + sectorNombre;
                                    },
                                    label: function(context) {
                                        const sectorIndex = context.dataIndex;
                                        const isCalificados = context.datasetIndex === 0;

                                        // Obtener el porcentaje del gráfico
                                        const porcentaje = context.parsed.y;

                                        // Obtener totales por sector desde los datos actualizados
                                        const totalesPorSector = window.totalesPorSector || {};
                                        const totalSector = isCalificados ? 
                                            (totalesPorSector.calificados?.[sectorIndex] || 0) : 
                                            (totalesPorSector.no_calificados?.[sectorIndex] || 0);

                                        // Calcular cuántos comuneros asistieron
                                        const asistieron = Math.round((porcentaje * totalSector) / 100);

                                        const tipo = isCalificados ? 'Calificados' : 'No calificados';
                                        return tipo + ': ' + asistieron + ' de ' + totalSector + ' comuneros (' + porcentaje + '%)';
                                    }
                                }
                            },
                            datalabels: { display: false }
                        }
                    }
                });
            }

            // Crear el gráfico inicial
            createAsistenciaChart();

            // Escuchar eventos de Livewire para actualizar el gráfico
            document.addEventListener('livewire:init', () => {
                Livewire.hook('morph.updated', ({el, component}) => {
                    // Actualizar el gráfico cuando Livewire actualice la página
                    setTimeout(() => {
                        // Actualizar datos antes de recrear el gráfico
                        if (typeof window.updateAsistenciaData === 'function') {
                            window.updateAsistenciaData();
                        }
                        createAsistenciaChart();
                    }, 100);
                });
            });
        });
    </script>
    <style>
    /* ==== Efecto de brillo para la barra de progreso ==== */
    .progress-bar {
    position: relative;
    overflow: hidden;
    }

    .progress-bar::after {
    content: "";
    position: absolute;
    top: 0;
    left: -50%;
    width: 50%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
    animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
    100% { left: 100%; }
    }
    </style>
</div>