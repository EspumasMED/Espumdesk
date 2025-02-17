<x-filament-panels::page>
    <div class="mb-4">
        <h2 class="text-2xl font-bold tracking-tight">Control de Accesos y su nivel de criticidad</h2>
        <p class="mt-1 text-sm text-gray-500">Visualiza y gestiona los accesos de usuarios al software.</p>
    </div>

    <!-- Componente de información de criticidad mejorado -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-lg p-4">
        <div x-data="{ open: true }" class="w-full"> <!-- Cambiado a true para que inicie abierto -->
            <button 
                @click="open = !open" 
                class="flex justify-between items-center w-full text-left font-medium p-3 hover:bg-white/50 rounded-lg transition-all duration-200"
            >
                <span class="text-lg text-indigo-900 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Niveles de Criticidad - Definiciones
                </span>
                <svg 
                    :class="{'rotate-180': open}" 
                    class="w-5 h-5 transition-transform duration-200 text-indigo-600" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Crítico -->
                <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border-t-4 border-red-500">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 font-semibold text-gray-900">Crítico</h3>
                    </div>
                    <p class="text-sm text-gray-600">
                        Software fundamental e imprescindible para la continuidad operativa. Incluye sistemas que manejan información financiera sensible, controlan procesos vitales o contienen datos personales protegidos.
                    </p>
                </div>

                <!-- Alto -->
                <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border-t-4 border-orange-500">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 font-semibold text-gray-900">Alto</h3>
                    </div>
                    <p class="text-sm text-gray-600">
                        Sistemas esenciales para mantener la eficiencia operativa. Incluye gestión de recursos humanos, facturación e inventario principal.
                    </p>
                </div>

                <!-- Medio -->
                <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border-t-4 border-yellow-500">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 font-semibold text-gray-900">Medio</h3>
                    </div>
                    <p class="text-sm text-gray-600">
                        Sistemas que soportan procesos importantes pero no esenciales. Incluye herramientas de colaboración y sistemas de reportería secundarios.
                    </p>
                </div>

                <!-- Bajo -->
                <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border-t-4 border-gray-500">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-gray-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 font-semibold text-gray-900">Bajo</h3>
                    </div>
                    <p class="text-sm text-gray-600">
                        Herramientas y aplicaciones útiles pero no esenciales. Incluye software de productividad general y sistemas complementarios.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <x-filament::grid class="gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            {{ $this->form }}
            
            <!-- Búsqueda por nombre -->
            <div class="mt-4">
                <x-filament::input
                    type="search"
                    wire:model.debounce.500ms="search"
                    placeholder="Buscar por nombre..."
                />
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="p-2 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario
                        </th>
                        @foreach($this->getSoftware() as $software)
                            <th class="p-2 border-b bg-gray-50 text-center">
                                <div class="text-sm font-medium text-gray-900">{{ $software->nombre }}</div>
                                <div class="text-xs text-gray-500">
                                    @switch($software->criticidad)
                                        @case('1')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Crítico
                                            </span>
                                            @break
                                        @case('2')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                Alto
                                            </span>
                                            @break
                                        @case('3')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Medio
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Bajo
                                            </span>
                                    @endswitch
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($this->getUsers() as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border-b whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $user->area }}
                                            </span>
                                            <span class="ml-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $user->sede }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @foreach($this->getSoftware() as $software)
                                <td class="p-2 border-b text-center">
                                    @php
                                        $pivotData = $user->software->where('id', $software->id)->first()?->pivot;
                                        $hasAccess = $pivotData && $pivotData->has_access;
                                    @endphp
                                    <label class="inline-flex items-center">
                                        <input 
                                            type="checkbox" 
                                            wire:click="updateAccess({{ $user->id }}, {{ $software->id }})"
                                            @checked($hasAccess)
                                            class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                                        >
                                    </label>
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $this->getSoftware()->count() + 1 }}" class="text-center py-8">
                                <div class="text-gray-500">No hay datos para mostrar</div>
                                <div class="text-sm text-gray-400">Ajusta los filtros o agrega más registros</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::grid>
</x-filament-panels::page>