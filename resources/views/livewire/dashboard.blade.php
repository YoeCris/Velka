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

    <!-- Contenido principal -->
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
                        <div class="ml-4">
                            <p class="text-2xl font-medium text-gray-500">Total Comuneros</p>
                            <p class="text-5xl font-bold text-gray-900">{{ $estadisticasGenerales['total_comuneros'] }}</p>
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
                        <div class="ml-4">
                            <p class="text-2xl font-medium text-gray-500">Calificados</p>
                            <p class="text-5xl font-bold text-gray-900">{{ $estadisticasGenerales['comuneros_calificados'] }}</p>
                            <p class="text-xl text-gray-500">{{ $estadisticasGenerales['porcentaje_asistencia_calificados'] }}% asistencia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- No Calificados -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-2xl font-medium text-gray-500">No Calificados</p>
                            <p class="text-5xl font-bold text-gray-900">{{ $estadisticasGenerales['comuneros_no_calificados'] }}</p>
                            <p class="text-xl text-gray-500">{{ $estadisticasGenerales['porcentaje_asistencia_no_calificados'] }}% asistencia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Porcentaje Asistencia -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-orange-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-2xl font-medium text-gray-500">% Asistencia General</p>
                            <p class="text-5xl font-bold text-gray-900">{{ $estadisticasGenerales['porcentaje_asistencia_total'] }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribución de Comuneros por Sector - Cards con donut -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Distribución de Comuneros</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($estadisticasPorSector as $s)
                        @php
                            $sector   = (string)($s['sector'] ?? 'Sector');
                            $total    = (int)($s['total'] ?? 0);
                            $cal      = (int)($s['calificados'] ?? $s['cal'] ?? 0);
                            $nocalRaw = $s['no_calificados'] ?? $s['noCalificados'] ?? $s['noCalif'] ?? null;
                            $nocal    = is_null($nocalRaw) ? max(0, $total - $cal) : (int)$nocalRaw;

                            if ($cal < 0) $cal = 0;
                            if ($nocal < 0) $nocal = 0;
                            if ($total <= 0) { $total = $cal + $nocal; }

                            $pCal = $total > 0 ? round(($cal / $total) * 100) : 0;
                            $pNo  = max(0, 100 - $pCal);

                            $slug  = \Illuminate\Support\Str::slug($sector, '-');
                        @endphp

                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:bg-gray-100 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-gray-900 truncate">{{ $sector }}</h4>
                                <span class="text-xs text-gray-500">{{ $total }} total</span>
                            </div>

                            <div class="flex items-center gap-4">
                                <!-- Donut mini -->
                                <div class="w-24 h-24">
                                    <canvas id="donut-dist-{{ $slug }}"></canvas>
                                </div>

                                <!-- Etiquetas compactas -->
                                <div class="flex-1 space-y-2 text-xs text-gray-700">
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center gap-1">
                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span> Calificados
                                        </span>
                                        <span class="font-semibold text-green-600">{{ $pCal }}% ({{ $cal }})</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center gap-1">
                                            <span class="w-2 h-2 bg-blue-600 rounded-full"></span> No calificados
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
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">Análisis de Asistencia por Sector</h3>
                    <span class="text-xs text-gray-500">Barras comparativas</span>
                </div>

                @php
                    $labelsAsis = [];
                    $asisCal = [];
                    $asisNo  = [];
                    foreach ($tendenciaAsistenciaPorSector as $sec) {
                        $labelsAsis[] = (string)($sec['sector'] ?? 'Sector');

                        $pC  = $sec['porcentaje_calificados'] ?? null;
                        $pNC = $sec['porcentaje_no_calificados'] ?? null;

                        if (is_null($pC) || is_null($pNC)) {
                            $tc = (int)($sec['total_calificados'] ?? 0);
                            $tn = (int)($sec['total_no_calificados'] ?? 0);
                            $sum = max(1, $tc + $tn);
                            $pC = round(($tc / $sum) * 100, 2);
                            $pNC = round(($tn / $sum) * 100, 2);
                        } else {
                            $pC  = max(0, (float)$pC);
                            $pNC = max(0, (float)$pNC);
                            $sum = max(1, $pC + $pNC);
                            $pC  = round(($pC / $sum) * 100, 2);
                            $pNC = round(($pNC / $sum) * 100, 2);
                        }

                        $asisCal[] = $pC;
                        $asisNo[]  = $pNC;
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
                                            <div class="bg-{{ $reunion['porcentaje_asistencia'] >= 70 ? 'green' : ($reunion['porcentaje_asistencia'] >= 50 ? 'yellow' : 'red') }}-500 h-2 rounded-full" 
                                                 style="width: {{ $reunion['porcentaje_asistencia'] }}%"></div>
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
    const ds = chart.data.datasets?.[0];
    if (!ds) return;
    const total = (ds.data || []).reduce((a,b)=>a + (Number(b)||0), 0);
    const cal   = Number(ds.data?.[0] || 0);
    const pct   = total > 0 ? Math.round((cal/total)*100) : 0;

    const {ctx} = chart, meta = chart.getDatasetMeta(0);
    if (!meta?.data?.[0]) return;
    const {x, y} = meta.data[0];

    ctx.save();
    ctx.font = (options?.fontSize || 18) + 'px ' + (Chart.defaults.font.family || 'sans-serif');
    ctx.fillStyle = options?.color || '#111827'; // Gray 900
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(pct + '%', x, y);
    ctx.restore();
  }
};
Chart.register(DoughnutCenterText);

document.addEventListener('DOMContentLoaded', () => {
    /* ---- Donuts de "Distribución de Comuneros" ---- */
    document.querySelectorAll('[id^="data-donut-dist-"]').forEach(el => {
        const id = el.id.replace('data-donut-dist-','');
        let data = [0,0];
        try { data = JSON.parse(el.textContent || '[0,0]'); } catch(e) {}
        const canvas = document.getElementById(`donut-dist-${id}`);
        if (!canvas) return;
        new Chart(canvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Calificados','No calificados'],
                datasets: [{
                    data,
                    backgroundColor: ['rgba(16,185,129,0.9)','rgba(28,75,230,0.9)'], // verde / azul
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: { bodyFont: { size: 12 }, titleFont: { size: 12 } },
                    doughnutCenterText: { fontSize: 30, color: '#111827' }
                }
            }
        });
    });

    /* ---- Barras dobles comparativas de Asistencia por sector ---- */
    const gEl = document.getElementById('data-asis-sectores');
    if (gEl) {
        let g = {};
        try { g = JSON.parse(gEl.textContent || '{}'); } catch(e) {}
        const ctx = document.getElementById('chartAsistenciaSectores');
        if (ctx) {
            // DESTRUIR CUALQUIER GRÁFICO EXISTENTE
            Chart.getChart(ctx)?.destroy();
            
            // CREAR GRÁFICO COMPLETAMENTE LIMPIO
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: g.labels || [],
                    datasets: [
                        { 
                            label: 'Calificados', 
                            data: g.cal || [], 
                            backgroundColor: 'rgba(16,185,129,0.8)', 
                            borderColor: 'rgba(16,185,129,1)',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        { 
                            label: 'No calificados', 
                            data: g.nocal || [], 
                            backgroundColor: 'rgba(239,68,68,0.8)', 
                            borderColor: 'rgba(239,68,68,1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: 0
                    },
                    animation: false, // DESACTIVAR ANIMACIONES
                    elements: {
                        bar: {
                            borderSkipped: false
                        }
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
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + '%';
                                }
                            }
                        },
                        // DESACTIVAR EXPLÍCITAMENTE TODOS LOS PLUGINS DE ETIQUETAS
                        datalabels: false,
                        chartAreaBorder: false,
                        annotation: false,
                        zoom: false,
                        title: false
                    },
                    // CONFIGURACIÓN ADICIONAL PARA EVITAR ETIQUETAS
                    onHover: null,
                    onClick: null
                }
            });
            
            // VERIFICAR Y REMOVER CUALQUIER PLUGIN DE ETIQUETAS POST-CREACIÓN
            if (chart.config && chart.config.plugins) {
                chart.config.plugins = chart.config.plugins.filter(plugin => 
                    plugin.id !== 'datalabels' && 
                    plugin.id !== 'chartjs-plugin-datalabels'
                );
            }
        }
    }

    
});
</script>