<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $apellido_paterno = '';
    public string $apellido_materno = '';
    public string $email = '';
    public string $dni = '';
    public string $fecha_nacimiento = '';
    public string $genero = '';
    public string $telefono = '';
    public string $sector = '';
    public string $direccion = '';
    public string $ocupacion = '';
    public string $estado_civil = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'dni' => ['required', 'string', 'size:8', 'unique:'.User::class],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'genero' => ['required', 'in:masculino,femenino,otro'],
            'telefono' => ['nullable', 'string', 'max:15'],
            'sector' => ['required', 'in:sector_1,sector_2,sector_3,sector_4'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'ocupacion' => ['nullable', 'string', 'max:255'],
            'estado_civil' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['condicion'] = 'no_calificado'; // Por defecto los nuevos comuneros no están calificados
        $validated['rol'] = 'comunero'; // Por defecto son comuneros
        $validated['activo'] = true;
        $validated['fecha_ingreso_comunidad'] = now()->toDateString();

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Registro de Comunero - Jatucani</h2>
        <p class="text-gray-600 mt-2">Complete todos los campos para registrarse como miembro de la comunidad</p>
    </div>

    <form wire:submit="register" class="space-y-6">
        <!-- Información Personal -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Información Personal</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Nombres -->
                <div>
                    <x-input-label for="name" value="Nombres *" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Apellido Paterno -->
                <div>
                    <x-input-label for="apellido_paterno" value="Apellido Paterno *" />
                    <x-text-input wire:model="apellido_paterno" id="apellido_paterno" class="block mt-1 w-full" type="text" name="apellido_paterno" required />
                    <x-input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
                </div>

                <!-- Apellido Materno -->
                <div>
                    <x-input-label for="apellido_materno" value="Apellido Materno *" />
                    <x-text-input wire:model="apellido_materno" id="apellido_materno" class="block mt-1 w-full" type="text" name="apellido_materno" required />
                    <x-input-error :messages="$errors->get('apellido_materno')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <!-- DNI -->
                <div>
                    <x-input-label for="dni" value="DNI *" />
                    <x-text-input wire:model="dni" id="dni" class="block mt-1 w-full" type="text" name="dni" required maxlength="8" pattern="[0-9]{8}" />
                    <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                    <p class="text-xs text-gray-500 mt-1">Ingrese 8 dígitos</p>
                </div>

                <!-- Fecha de Nacimiento -->
                <div>
                    <x-input-label for="fecha_nacimiento" value="Fecha de Nacimiento *" />
                    <x-text-input wire:model="fecha_nacimiento" id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento" required />
                    <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <!-- Género -->
                <div>
                    <x-input-label for="genero" value="Género *" />
                    <select wire:model="genero" id="genero" name="genero" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Seleccione...</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                    <x-input-error :messages="$errors->get('genero')" class="mt-2" />
                </div>

                <!-- Teléfono -->
                <div>
                    <x-input-label for="telefono" value="Teléfono" />
                    <x-text-input wire:model="telefono" id="telefono" class="block mt-1 w-full" type="tel" name="telefono" />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <!-- Estado Civil -->
                <div>
                    <x-input-label for="estado_civil" value="Estado Civil" />
                    <select wire:model="estado_civil" id="estado_civil" name="estado_civil" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Seleccione...</option>
                        <option value="soltero">Soltero(a)</option>
                        <option value="casado">Casado(a)</option>
                        <option value="conviviente">Conviviente</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viudo">Viudo(a)</option>
                    </select>
                    <x-input-error :messages="$errors->get('estado_civil')" class="mt-2" />
                </div>

                <!-- Ocupación -->
                <div>
                    <x-input-label for="ocupacion" value="Ocupación" />
                    <x-text-input wire:model="ocupacion" id="ocupacion" class="block mt-1 w-full" type="text" name="ocupacion" />
                    <x-input-error :messages="$errors->get('ocupacion')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Información de la Comunidad -->
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Información de la Comunidad</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Sector -->
                <div>
                    <x-input-label for="sector" value="Sector de Residencia *" />
                    <select wire:model="sector" id="sector" name="sector" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Seleccione su sector...</option>
                        <option value="sector_1">Sector 1 - Centro</option>
                        <option value="sector_2">Sector 2 - Norte</option>
                        <option value="sector_3">Sector 3 - Sur</option>
                        <option value="sector_4">Sector 4 - Este</option>
                    </select>
                    <x-input-error :messages="$errors->get('sector')" class="mt-2" />
                </div>

                <!-- Dirección -->
                <div>
                    <x-input-label for="direccion" value="Dirección" />
                    <x-text-input wire:model="direccion" id="direccion" class="block mt-1 w-full" type="text" name="direccion" placeholder="Av./Jr./Calle y número" />
                    <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                </div>
            </div>

            <div class="mt-4 p-3 bg-blue-100 rounded-md">
                <p class="text-sm text-blue-800">
                    <strong>Nota:</strong> Su registro será como "Comunero No Calificado" inicialmente. Para obtener la condición de "Comunero Calificado", debe cumplir con los requisitos establecidos por la comunidad y ser aprobado por la junta directiva.
                </p>
            </div>
        </div>

        <!-- Información de Cuenta -->
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Información de Cuenta</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Correo Electrónico *" />
                    <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Contraseña *" />
                    <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" value="Confirmar Contraseña *" />
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                ¿Ya está registrado?
            </a>

            <x-primary-button class="ms-4">
                Registrar Comunero
            </x-primary-button>
        </div>
    </form>
</div>
