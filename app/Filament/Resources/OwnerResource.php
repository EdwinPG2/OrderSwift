<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Filament\Forms\Components\Grid;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->maxLength(255)->label('Nombre'),
                TextInput::make('address')->maxLength(255)->required(),
                TextInput::make('city')->maxLength(100)->required(),
                TextInput::make('state')->maxLength(100)->required(),

                TextInput::make('web_page')->maxLength(150),
                TextInput::make('email')->maxLength(64)->required(),
                TextInput::make('image_path')->maxLength(100),
                TextInput::make('email_notifications')->maxLength(64)->required(),
                TextInput::make('username')->maxLength(64)->required(),
                TextInput::make('stripe_key')->maxLength(64),
                TextInput::make('stripe_secret')->maxLength(64),
                PhoneInput::make('phone'),
                PhoneInput::make('alternate_phone'),


            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'edit' => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
}
