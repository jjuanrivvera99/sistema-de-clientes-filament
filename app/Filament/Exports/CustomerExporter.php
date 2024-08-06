<?php

namespace App\Filament\Exports;

use App\Models\Customer;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CustomerExporter extends Exporter
{
    protected static ?string $model = Customer::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name')->label('Nombre'),
            ExportColumn::make('nationality')->label('Nacionalidad'),
            ExportColumn::make('residence_place')->label('Lugar de Residencia'),
            ExportColumn::make('postal_code')->label('Código Postal'),
            ExportColumn::make('cencus')->label('Empadronamiento Aproximado'),
            ExportColumn::make('marital_status')->label('Estado Civil'),
            ExportColumn::make('family')->label('Familia'),
            ExportColumn::make('notes')->label('Notas'),
            ExportColumn::make('document_number')->label('Número de Documento'),
            ExportColumn::make('documentType.name')->label('Tipo de Documento'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Tu exportación de clientes se ha completado y ' . number_format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . ' fueron exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' falló en exportarse.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'clientes-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
    }
}
