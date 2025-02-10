<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class UserImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $total = 0;
        foreach ($rows as $row) {
            try {
                if (empty($row['nombre'])) {
                    continue;
                }
                $total++;

                $correo = $row['correo_electronico'] ?? Str::slug($row['nombre']) . '@espumasmedellin.com.co';

                if (!User::where('email', $correo)->exists()) {
                    $usuario = User::create([
                        'name' => $row['nombre'],
                        'email' => $correo,
                        'area' => $row['area'] ?? null,
                        'sede' => $row['sede'] ?? null,
                        'telefono' => $row['telefono'] ?? null,
                        'cargo' => $row['cargo'] ?? null,
                        'estado' => 'activo',
                        'password' => bcrypt('password123', ['rounds' => 4])
                    ]);

                    $usuario->assignRole('panel_user');

                    Log::info('Usuario importado exitosamente', [
                        'nombre' => $row['nombre'],
                        'correo' => $correo,
                        'total_importados' => $total
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error al importar usuario', [
                    'error' => $e->getMessage(),
                    'fila' => $row
                ]);
            }
        }
    }
}
