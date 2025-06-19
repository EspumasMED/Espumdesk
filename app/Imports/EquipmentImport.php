<?php

namespace App\Imports;

use App\Models\Equipment;
use App\Models\Provider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EquipmentImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                // Saltar filas vacías
                if (empty(array_filter($row->toArray()))) {
                    continue;
                }

                // Saltar si el serial ya existe
                if (!empty($row['numero_de_serie']) && Equipment::where('serial_number', $row['numero_de_serie'])->exists()) {
                    continue;
                }

                // Obtener proveedor desde ID o nombre
                $providerInput = $row['proveedor'] ?? null;
                $provider = null;

                if (is_numeric($providerInput)) {
                    $provider = Provider::find((int) $providerInput);
                } elseif (!empty($providerInput)) {
                    $normalized = strtolower(trim(preg_replace('/\s+/', ' ', $providerInput)));
                    $provider = Provider::get()->first(function ($prov) use ($normalized) {
                        $dbName = strtolower(trim(preg_replace('/\s+/', ' ', $prov->company_name)));
                        return $dbName === $normalized;
                    });
                }

                // Crear el equipo
                Equipment::create([
                    'company'         => $this->getCompany($row['empresa'] ?? null),
                    'provider_id'     => $provider?->id,
                    'name'            => $row['nombre_del_equipo'] ?? null,
                    'model'           => $row['modelo'] ?? null,
                    'serial_number'   => $row['numero_de_serie'] ?? uniqid(),
                    'brand'           => $row['marca'] ?? null,
                    'status'          => $this->getStatus($row['estado'] ?? null),
                    'assigned_to'     => $row['asignado_a'] ?? null,
                    'area'            => $row['area_departamento'] ?? null,
                    'disco'           => $row['disco'] ?? null,
                    'procesador'      => $row['procesador'] ?? null,
                    'ram'             => $row['ram'] ?? null,
                    'otros'           => $row['otros'] ?? null,
                    'delivery_record' => $row['acta_de_entrega'] ?? null,
                    'notes'           => $provider ? ($row['notas'] ?? null) : 'Proveedor sin especificar',
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function getCompany(?string $empresa): ?string
    {
        $empresa = strtolower(trim($empresa ?? ''));

        return match (true) {
            str_contains($empresa, 'medellin') => 'espumas_medellin',
            str_contains($empresa, 'litoral') => 'espumados_litoral',
            default => null,
        };
    }

    private function getStatus(?string $estado): string
    {
        return match (strtolower(trim($estado ?? ''))) {
            'disponible' => 'available',
            'en uso' => 'in_use',
            'en mantenimiento' => 'maintenance',
            'en reparación', 'en reparacion' => 'repair',
            'dado de baja' => 'retired',
            'reservado' => 'reserved',
            default => 'in_use',
        };
    }
}
