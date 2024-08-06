<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use App\Models\Membership;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\MembershipResource\Pages;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;

    protected static ?string $modelLabel = 'Afiliaciones';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $navigationLabel = 'Afiliaciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('membership_number')
                    ->label('Número de Afiliación')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\DatePicker::make('membership_date')
                    ->label('Fecha de Afiliación')
                    ->required(),

                Forms\Components\Select::make('membership_status')
                    ->label('Estado de Afiliación')
                    ->options([
                        'active' => 'Activo',
                        'inactive' => 'Inactivo',
                    ])
                    ->required(),

                Forms\Components\Select::make('customer_id')
                    ->label('Cliente')
                    ->searchable() // Habilitar búsqueda
                    ->getSearchResultsUsing(function (string $query) {
                        return Customer::query()
                            ->where('name', 'like', "%{$query}%")
                            ->orWhere('document_number', 'like', "%{$query}%")
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->getOptionLabelUsing(fn($value): ?string => Customer::find($value)?->name)
                    ->required(),

                Forms\Components\Textarea::make('wish')
                    ->label('Deseo')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('membership_number')
                    ->label('Número de Afiliación'),

                Tables\Columns\TextColumn::make('membership_date')
                    ->label('Fecha de Afiliación')
                    ->date(),

                Tables\Columns\TextColumn::make('membership_status')
                    ->label('Estado'),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Cliente'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMemberships::route('/'),
            'create' => Pages\CreateMembership::route('/create'),
            'edit' => Pages\EditMembership::route('/{record}/edit'),
        ];
    }
}
