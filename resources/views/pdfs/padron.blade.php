<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background-image: url('data:image/png;base64,{{ $logoBase64 ?? '' }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 400px;
            background-opacity: 0.1;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        
        .filtros {
            background-color: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .filtros h3 {
            margin: 0 0 10px 0;
            font-size: 13px;
        }
        
        .filtros p {
            margin: 5px 0;
            font-size: 11px;
        }
        
        .tabla-comuneros {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .tabla-comuneros th {
            background-color: #333;
            color: white;
            padding: 8px 5px;
            text-align: center;
            font-size: 10px;
            border: 1px solid #000;
        }
        
        .tabla-comuneros td {
            padding: 6px 5px;
            text-align: left;
            font-size: 9px;
            border: 1px solid #ccc;
        }
        
        .tabla-comuneros tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .condicion-calificado {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 5px;
            border-radius: 3px;
            text-align: center;
        }
        
        .condicion-no-calificado {
            background-color: #f8d7da;
            color: #721c24;
            padding: 2px 5px;
            border-radius: 3px;
            text-align: center;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 10px;
            font-size: 10px;
            color: #666;
        }
        
        .page-number:before {
            content: "Página " counter(page);
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.1;
            z-index: -1;
            font-size: 48px;
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="watermark">COMUNIDAD JATUCACHI</div>
    
    <div class="header">
        <h1>COMUNIDAD JATUCACHI</h1>
        <h2>{{ $titulo }}</h2>
        <p>Fecha de generación: {{ $fecha_generacion->format('d/m/Y H:i:s') }}</p>
    </div>
    
    @if(!empty($filtros))
    <div class="filtros">
        <h3>Filtros aplicados:</h3>
        @if(!empty($filtros['buscar']))
            <p><strong>Búsqueda:</strong> {{ $filtros['buscar'] }}</p>
        @endif
        @if(!empty($filtros['sector']))
            <p><strong>Sector:</strong> {{ $filtros['sector'] }}</p>
        @endif
        @if(!empty($filtros['condicion']))
            <p><strong>Condición:</strong> {{ $filtros['condicion'] === 'calificado' ? 'Calificado' : 'No Calificado' }}</p>
        @endif
        @if(isset($filtros['activo']))
            <p><strong>Estado:</strong> {{ $filtros['activo'] ? 'Activo' : 'Inactivo' }}</p>
        @endif
    </div>
    @endif
    
    <table class="tabla-comuneros">
        <thead>
            <tr>
                <th style="width: 8%">DNI</th>
                <th style="width: 20%">Nombres</th>
                <th style="width: 20%">Apellidos</th>
                <th style="width: 8%">Género</th>
                <th style="width: 12%">Sector</th>
                <th style="width: 10%">Condición</th>
                <th style="width: 10%">F. Ingreso</th>
                <th style="width: 7%">% Asist.</th>
                <th style="width: 5%">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comuneros as $comunero)
            <tr>
                <td>{{ $comunero->dni }}</td>
                <td>{{ $comunero->nombres }}</td>
                <td>{{ $comunero->apellidos }}</td>
                <td>{{ ucfirst($comunero->genero) }}</td>
                <td>{{ $comunero->sector->nombre }}</td>
                <td>
                    <span class="{{ $comunero->condicion === 'calificado' ? 'condicion-calificado' : 'condicion-no-calificado' }}">
                        {{ $comunero->condicion === 'calificado' ? 'Calificado' : 'No Calificado' }}
                    </span>
                </td>
                <td>{{ $comunero->fecha_ingreso->format('d/m/Y') }}</td>
                <td>{{ number_format($comunero->porcentaje_asistencia, 1) }}%</td>
                <td>{{ $comunero->activo ? 'Activo' : 'Inactivo' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p><strong>Total de registros:</strong> {{ $total_registros }}</p>
        <p>Generado por: Sistema de Gestión Comunal - Comunidad Jatucachi</p>
        <div class="page-number"></div>
    </div>
</body>
</html>
