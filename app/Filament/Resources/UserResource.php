<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\{CreateUser, EditUser};
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Usuarios';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', fn ($record) => $record),

                Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof CreateUser)
                    ->minLength(8)
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->hidden(fn ($livewire) => $livewire instanceof EditUser),

                Forms\Components\TextInput::make('password_confirmation')
                    ->label('Confirmar Contraseña')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof CreateUser)
                    ->same('password')
                    ->hidden(fn ($livewire) => $livewire instanceof EditUser),

                Forms\Components\Section::make('Reseteo de Contraseña')
                    ->schema([
                        Forms\Components\TextInput::make('new_password')
                            ->label('Nueva Contraseña')
                            ->password()
                            ->minLength(8)
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->nullable(),
                            
                        Forms\Components\TextInput::make('new_password_confirmation')
                            ->label('Confirmar Nueva Contraseña')
                            ->password()
                            ->same('new_password')
                            ->nullable(),
                    ])
                    ->hidden(fn ($livewire) => $livewire instanceof CreateUser)
                    ->collapsible()
                    ->collapsed(fn ($livewire) => !$livewire?->record?->exists),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
