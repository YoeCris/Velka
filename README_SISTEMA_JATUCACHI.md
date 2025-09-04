# Sistema de Gestión Comunal - Comunidad Jatucachi

Sistema desarrollado en Laravel 12 con Livewire 3 para la gestión integral de la Comunidad Jatucachi, incluyendo padrón de comuneros, reuniones, asistencias y reportes.

## 🏗️ Stack Tecnológico

- **Framework:** Laravel 12
- **Frontend:** Livewire 3 (con Volt)
- **Autenticación:** Laravel Breeze
- **Estilos:** TailwindCSS
- **Base de datos:** SQLite/MySQL
- **PDF:** DomPDF / Browsershot
- **Auditoría:** Spatie Activity Log

## 🎯 Características Principales

### 👥 Gestión de Usuarios y Roles
- **Superadministrador:** Acceso completo al sistema
- **Administrador de Sector:** Acceso limitado a su sector

### 📋 Padrón Comunal
- CRUD completo de comuneros (solo superadmin)
- Filtros avanzados por DNI, nombre, sector, condición y estado
- Soft delete para preservar historial
- Gestión de cargos con historial completo
- Exportación a PDF con marca de agua

### 🏛️ Sectores de la Comunidad
- Central
- Catahui  
- Jayuyapu
- Titire

### 📅 Gestión de Reuniones
- Solo reuniones generales (no sectoriales)
- Tipos: Ordinaria y Extraordinaria
- Control de asistencias con entrada y salida separadas
- Umbral de tardanza configurable (40 minutos por defecto)

### 📊 Sistema de Asistencias
- Registro por DNI (preparado para futuro escáner PDF417)
- Sistema de puntuación:
  - **Entrada a tiempo:** 0.50 puntos
  - **Entrada tardía:** 0.25 puntos
  - **Falta entrada:** 0.00 puntos
  - **Salida:** 0.50 puntos adicionales
  - **Sin salida:** 0.00 puntos adicionales

### 🎯 Condiciones de Comuneros
- **Calificado:** ≥ 50% asistencia
- **No Calificado:** < 40% asistencia  
- **Sin cambio:** Entre 40% y 50% (mantiene condición actual)
- Actualización individual y masiva por períodos

### 📈 Dashboard y Reportes
- Métricas generales y por sector
- Gráficos de tendencia de asistencia
- Exportación de reportes en PDF
- Registro de actividad completo

## 🚀 Instalación y Configuración

### Prerrequisitos
```bash
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/SQLite
```

### Pasos de Instalación

1. **Clonar y configurar el proyecto:**
```bash
cd /ruta/del/proyecto/community
composer install
npm install && npm run build
```

2. **Configurar base de datos:**
```bash
# Copiar archivo de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Configurar en .env:
DB_CONNECTION=mysql
DB_DATABASE=comunidad_jatucachi
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

3. **Ejecutar migraciones y seeders:**
```bash
php artisan migrate
php artisan db:seed
```

4. **Crear directorio de reportes:**
```bash
php artisan storage:link
mkdir -p storage/app/public/reportes_jatucachi
```

### 👤 Usuarios por Defecto

Después de ejecutar los seeders:

**Superadministrador:**
- Email: admin@jatucachi.com
- Password: admin123

**Administradores de Sector:**
- Central: admin.central@jatucachi.com
- Catahui: admin.catahui@jatucachi.com  
- Jayuyapu: admin.jayuyapu@jatucachi.com
- Titire: admin.titire@jatucachi.com
- Password: admin123 (todos)

## 🏃‍♂️ Uso del Sistema

### Para Superadministradores:
- ✅ Gestión completa del padrón comunal
- ✅ Creación y administración de reuniones
- ✅ Registro de asistencias
- ✅ Actualización masiva de condiciones
- ✅ Acceso a todos los reportes y auditoría
- ✅ Visualización de todos los sectores


## 🔧 Comandos Útiles

```bash
# Ejecutar migraciones
php artisan migrate

# Refrescar datos de prueba
php artisan migrate:refresh --seed

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generar nuevos componentes Livewire
php artisan make:livewire NombreComponente
```

## 📋 Funcionalidades Pendientes

- [ ] Implementación de escáner PDF417 para DNI peruano
- [ ] Gráficos avanzados con Chart.js/Browsershot
- [ ] Notificaciones automáticas
- [ ] Exportación de asistencias en Excel
- [ ] Dashboard responsive mejorado
- [ ] Tests automatizados completos

## 🐛 Troubleshooting

### Problemas Comunes:

1. **Error de permisos en storage:**
```bash
sudo chown -R www-data:www-data storage/
sudo chmod -R 775 storage/
```

2. **PDFs no se generan:**
```bash
# Verificar que existe el directorio
mkdir -p storage/app/public/reportes_jatucachi
chmod 775 storage/app/public/reportes_jatucachi
```

3. **Middlewares no funcionan:**
```bash
php artisan config:clear
php artisan route:clear
```

## 🤝 Contribución

Este sistema fue desarrollado específicamente para la Comunidad Jatucachi siguiendo sus requerimientos y estatutos internos.

## 📄 Licencia

Sistema propietario desarrollado para la Comunidad Jatucachi.

---

**Versión:** 1.0.0  
**Fecha:** Enero 2025  
**Desarrollado para:** Comunidad Jatucachi
