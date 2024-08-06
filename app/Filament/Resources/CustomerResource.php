<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\CustomerExporter;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerResource\RelationManagers;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $modelLabel = 'Clientes';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('nationality')
                    ->label('Nacionalidad')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('residence_place')
                    ->label('Lugar de Residencia')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('postal_code')
                    ->label('Código Postal')
                    ->maxLength(20),

                Forms\Components\TextInput::make('cencus')
                    ->label('Empadronamiento Aproximado'),

                Forms\Components\TextInput::make('marital_status')
                    ->label('Estado Civil')
                    ->maxLength(255),

                Forms\Components\Select::make('document_type_id')
                    ->label('Tipo de Documento')
                    ->relationship('documentType', 'name')
                    ->required(),

                Forms\Components\TextInput::make('document_number')
                    ->label('Número de Documento')
                    ->required()
                    ->maxLength(50),

                Forms\Components\Textarea::make('family')
                    ->label('Familia'),

                Forms\Components\Textarea::make('notes')
                    ->label('Observaciones'),

                Forms\Components\Fieldset::make('Afiliación')
                    ->label('Afiliación')
                    ->schema([
                        Forms\Components\TextInput::make('membership_number')
                            ->label('Número de Afiliación')
                            ->maxLength(255)
                            ->required()
                            ->default(fn ($record) => $record->membership->membership_number ?? ''),

                        Forms\Components\DatePicker::make('membership_date')
                            ->label('Fecha de Afiliación')
                            ->required()
                            ->default(fn ($record) => $record->membership->membership_date ?? null),

                        Forms\Components\Select::make('membership_status')
                            ->label('Estado de Afiliación')
                            ->options([
                                'active' => 'Activo',
                                'inactive' => 'Inactivo',
                            ])
                            ->required()
                            ->default(fn ($record) => $record->membership->membership_status ?? ''),

                        Forms\Components\Textarea::make('wish')
                            ->label('Deseo')
                            ->maxLength(65535)
                            ->default(fn ($record) => $record->membership->wish ?? ''),
                    ])
                    ->columns(2)
                    ->relationship('membership'),

                Forms\Components\Repeater::make('contacts')
                    ->label('Contactos')
                    ->relationship('contacts')
                    ->schema([
                        Forms\Components\TextInput::make('contact_number')
                            ->label('Número de Contacto')
                            ->maxLength(20),
                        
                        Forms\Components\TextInput::make('address')
                            ->label('Dirección')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->maxLength(255),
                    ])
                    ->addActionLabel('Añadir Contacto'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('nationality')
                    ->label('Nacionalidad'),
                Tables\Columns\TextColumn::make('documentType.name')
                    ->label('Tipo de Documento'),
                Tables\Columns\TextColumn::make('document_number')
                    ->label('Número de Documento')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()->exporter(CustomerExporter::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
