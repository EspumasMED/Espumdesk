<x-filament-panels::page>
   <div class="mb-4">
       <h2 class="text-2xl font-bold tracking-tight">Control de Accesos y su nivel de criticidad </h2>
       <p class="mt-1 text-sm text-gray-500">Visualiza y gestiona los accesos de usuarios al software.</p>
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