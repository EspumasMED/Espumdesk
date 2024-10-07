<div>
    <div class="space-y-4">
        <!-- Información del usuario -->
        <div class="bg-blue-100 p-2 rounded-lg shadow text-sm">
            <div class="font-semibold">{{ $record->user->name }}</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 mt-2">
                <div>
                    <p>Email: {{ $record->user->email }}</p>
                    <p>Área: {{ $record->user->area }}</p>
                </div>
                <div>
                    <p>Sede: {{ $record->user->sede }}</p>
                    <p>Teléfono: {{ $record->user->telefono }}</p>
                </div>
                <div>
                    <p>Cargo: {{ $record->user->cargo }}</p>
                </div>
            </div>
        </div>

        <!-- Detalles del ticket -->
        <div class="bg-green-100 p-2 rounded-lg shadow text-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                <div>
                    <p><span class="font-semibold">Categoría:</span> {{ $record->category->name }}</p>
                </div>
                <div>
                    <p><span class="font-semibold">Subcategoría:</span> {{ $record->subcategory->name }}</p>
                </div>
                <div>
                    <p>
                        <span class="font-semibold">Estado:</span> 
                        <span class="px-2 py-1 rounded-full text-xs
                            @if($record->status === 'abierto') bg-yellow-200 text-yellow-800
                            @elseif($record->status === 'cerrado') bg-green-200 text-green-800
                            @else bg-gray-200 text-gray-800
                            @endif">
                            {{ ucfirst($record->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Descripción del ticket -->
        <div class="bg-white p-2 rounded-lg shadow">
            <h3 class="font-semibold mb-2">Descripción</h3>
            <p class="whitespace-pre-wrap">{{ $record->description }}</p>
        </div>

        <!-- Respuesta existente (si hay) -->
        @if($record->response)
            <div class="bg-yellow-100 p-2 rounded-lg shadow">
                <h3 class="font-semibold mb-2">Respuesta</h3>
                <p>{{ $record->response }}</p>
            </div>
        @endif

        <!-- Archivo adjunto (si hay) -->
        @if($record->file_path)
            <div class="mt-2">
                @if(Str::endsWith(strtolower($record->file_path), ['.jpg', '.jpeg', '.png', '.gif']))
                    <img src="{{ Storage::url($record->file_path) }}" alt="Archivo adjunto" class="max-w-full h-auto rounded">
                @else
                    <a href="{{ Storage::url($record->file_path) }}" target="_blank" class="text-blue-500 hover:text-red-500">
                        Ver archivo adjunto
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- El formulario de respuesta se manejará automáticamente por Filament -->
</div>