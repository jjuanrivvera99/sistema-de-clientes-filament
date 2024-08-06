<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\TrashedCustomerResource\Pages;

class TrashedCustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationLabel = 'Papelera';

    protected static ?string $modelLabel = 'Clientes borrados';

    protected static ?string $navigationIcon = 'heroicon-o-trash';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->disabled(),

                Forms\Components\TextInput::make('document_number')
                    ->label('Número de Documento')
                    ->disabled(),

                Forms\Components\Textarea::make('notes')
                    ->label('Notas')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn () => Customer::onlyTrashed())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('document_number')
                    ->label('Número de Documento')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Eliminado el')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrashedCustomers::route('/'),
            // 'edit' => Pages\EditTrashedCustomer::route('/{record}/edit'),
        ];
    }
}
