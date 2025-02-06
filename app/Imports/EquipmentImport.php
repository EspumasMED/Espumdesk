<?php

namespace App\Imports;

use App\Models\Equipment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EquipmentImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                // Si el serial number existe, omite el registro
                if (Equipment::where('serial_number', $row['numero_de_serie'])->exists()) {
                    continue;
                }

                // Si no hay ningún dato en la fila, omite el registro
                if (empty(array_filter($row->toArray()))) {
                    continue;
                }

                $provider = \App\Models\Provider::where('company_name', $row['proveedor'])->first();

                $data = [
                    'company' => $row['empresa'] === 'Espumas Medellín' ? 'espumas_medellin' : null,
                    'name' => $row['nombre'] ?? null,
                    'model' => $row['modelo'] ?? null,
                    'serial_number' => $row['numero_de_serie'] ?? uniqid(),
                    'brand' => $row['marca'] ?? null,
                    'provider_id' => $provider ? $provider->id : null,
                    'status' => $row['estado'] ? $this->getStatus($row['estado']) : 'available',
                    'assigned_to' => $row['asignado_a'] ?? null,
                    'area' => $row['area'] ?? null,
                    'delivery_record' => $row['acta'] ?? null,
                    'notes' => $provider ? null : 'Proveedor sin especificar'
                ];

                Equipment::create($data);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function getStatus($estado)
    {
        return match ($estado) {
            'Disponible' => 'available',
            'En uso' => 'in_use',
            'En mantenimiento' => 'maintenance',
            'En reparación' => 'repair',
            'Dado de baja' => 'retired',
            'Reservado' => 'reserved',
            default => 'available'
        };
    }
}
