<div style="font-family: sans-serif; color: #000">

    <h2 style="text-align: center; color: #FF5C1B; font-weight: bold;">HOJA DE VIDA DEL EQUIPO TECNOLÓGICO</h2>

    <!-- Sección 1: Datos de ubicación -->
    <h3 style="background: #FF5C1B; color: #fff; padding: 8px;">1. DATOS DE UBICACIÓN DEL EQUIPO</h3>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
        <tr>
            <td style="width: 25%; font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Nombre del usuario asignado</td>
            <td style="border: 1px solid #000;">{{ $equipment->assigned_to ?? '---' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Área</td>
            <td style="border: 1px solid #000;">{{ $equipment->area ?? '---' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Empresa</td>
            <td style="border: 1px solid #000;">{{ $equipment->company ?? '---' }}</td>
        </tr>
    </table>

    <!-- Sección 2: Datos proveedor -->
    <h3 style="background: #FF5C1B; color: #fff; padding: 8px;">2. DATOS DEL PROVEEDOR</h3>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
        <tr>
            <td style="width: 25%; font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Proveedor</td>
            <td style="border: 1px solid #000;">{{ $equipment->provider->company_name ?? '---' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Contacto</td>
            <td style="border: 1px solid #000;">{{ $equipment->provider->phone ?? '---' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Correo electrónico</td>
            <td style="border: 1px solid #000;">{{ $equipment->provider->email ?? '---' }}</td>
        </tr>
    </table>

    <!-- Sección 3: Datos del equipo -->
    <h3 style="background: #FF5C1B; color: #fff; padding: 8px;">3. DATOS DEL EQUIPO</h3>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
        <tr>
            <td style="width: 25%; font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Clase de equipo</td>
            <td style="border: 1px solid #000;">{{ $equipment->name }}</td>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Marca</td>
            <td style="border: 1px solid #000;">{{ $equipment->brand }}</td>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">RAM</td>
            <td style="border: 1px solid #000;">{{ $equipment->ram }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Serial</td>
            <td style="border: 1px solid #000;">{{ $equipment->serial_number }}</td>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Procesador</td>
            <td style="border: 1px solid #000;">{{ $equipment->procesador }}</td>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Otros</td>
            <td style="border: 1px solid #000;">{{ $equipment->otros }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Disco</td>
            <td style="border: 1px solid #000;">{{ $equipment->disco }}</td>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Modelo</td>
            <td style="border: 1px solid #000;">{{ $equipment->model }}</td>
        </tr>
    </table>

    <!-- Sección 4: Perifericos -->
    <h3 style="background: #FF5C1B; color: #fff; padding: 8px;">4. PERIFÉRICOS</h3>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
        @forelse ($equipment->perifericos as $periferico)
            <tr>
                <td style="width: 25%; font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Periférico</td>
                <td style="border: 1px solid #000;">{{ $periferico->tipo_periferico === 'Otros' ? ($periferico->tipo_personalizado ?? '---') : $periferico->tipo_periferico }}</td>
                <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Marca</td>
                <td style="border: 1px solid #000;">{{ $periferico->marca }}</td>
                <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Serial</td>
                <td style="border: 1px solid #000;">{{ $periferico->numero_serie }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; border: 1px solid #000;">No hay periféricos registrados</td>
            </tr>
        @endforelse
    </table>

    <!-- Sección 5: Características y Actividades del Mantenimiento -->
    <h3 style="background: #FF5C1B; color: #fff; padding: 8px;">5. CARACTERÍSTICAS Y ACTIVIDADES DEL MANTENIMIENTO</h3>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
        <tr>
            <td style="width: 25%; font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Periodicidad</td>
            <td colspan="5" style="border: 1px solid #000;">{{ $equipment->caracteristicasMantenimiento->periodicidad ?? '---' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Mantenimiento físico</td>
            <td colspan="5" style="border: 1px solid #000;">{{ $equipment->caracteristicasMantenimiento->mantenimiento_fisico ?? '---' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Mantenimiento al software</td>
            <td colspan="5" style="border: 1px solid #000;">{{ $equipment->caracteristicasMantenimiento->mantenimiento_software ?? '---' }}</td>
        </tr>
    </table>

    <!-- Sección 6: Seguimiento del Mantenimiento Preventivo -->
    <h3 style="background: #FF5C1B; color: #fff; padding: 8px;">6. SEGUIMIENTO DEL MANTENIMIENTO PREVENTIVO</h3>
    @forelse ($equipment->seguimientosPreventivos as $registro)
        <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-bottom: 15px;">
            <tr>
                <td style="width: 25%; font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Fecha de mantenimiento programado</td>
                <td style="border: 1px solid #000;">{{ $registro->fecha_mantenimiento_programado }}</td>
                <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Fecha de realización</td>
                <td style="border: 1px solid #000;">{{ $registro->fecha_realizacion ?? '---' }}</td>
                <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Responsable del mantenimiento</td>
                <td style="border: 1px solid #000;">{{ $registro->responsable }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Observaciones y/o recomendaciones</td>
                <td colspan="5" style="border: 1px solid #000;">{{ $registro->observaciones ?? '---' }}</td>
            </tr>
        </table>
    @empty
        <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
            <tr>
                <td style="text-align: center; border: 1px solid #000;">No hay registros de mantenimiento preventivo</td>
            </tr>
        </table>
    @endforelse



    <!-- Sección 7: Seguimiento del Mantenimiento Correctivo -->
    <h3 style="background: #FF5C1B; color: #fff; padding: 8px;">7. SEGUIMIENTO DEL MANTENIMIENTO CORRECTIVO</h3>
    @forelse ($equipment->seguimientosCorrectivos as $registro)
        <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-bottom: 15px;">
            <tr>
                <td style="width: 25%; font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Fecha de realización</td>
                <td style="border: 1px solid #000;">{{ $registro->fecha_realizacion }}</td>
                <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Responsable</td>
                <td style="border: 1px solid #000;">{{ $registro->responsable }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Repuestos</td>
                <td colspan="3" style="border: 1px solid #000;">{{ $registro->repuestos ?? '---' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; background: #FEC3A2; border: 1px solid #000;">Servicio técnico realizado</td>
                <td colspan="3" style="border: 1px solid #000;">{{ $registro->servicio_realizado }}</td>
            </tr>
        </table>
    @empty
        <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
            <tr>
                <td style="text-align: center; border: 1px solid #000;">No hay registros de mantenimiento correctivo</td>
            </tr>
        </table>
    @endforelse





    @if($equipment->delivery_record)
        <div style="margin-top: 2rem; text-align: right;">
            <a href="{{ asset('storage/' . $equipment->delivery_record) }}" target="_blank"
               style="background: #FF5C1B; color: #fff; padding: 10px 15px; border-radius: 5px; text-decoration: none;">
                Descargar Acta de Entrega
            </a>
        </div>
    @endif
</div>
