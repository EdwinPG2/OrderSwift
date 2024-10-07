<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Branch;
use App\Models\Owner;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;

class RegisterBranch extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Branch';
    }

    public function form(Form $form): Form
    {
        $user = auth()->user();

        // Si el usuario no tiene un owner_id, mostrar el formulario para registrar un owner
        if (is_null($user->owner_id)) {
            return $form
                ->schema([
                    TextInput::make('owner_name')
                        ->required(),
                    TextInput::make('owner_address')
                        ->required(),
                    TextInput::make('owner_city')
                        ->required(),
                    TextInput::make('owner_state')
                        ->required(),
                    TextInput::make('owner_phone')
                        ->required(),
                    TextInput::make('owner_alternate_phone'),
                    TextInput::make('owner_web_page'),
                    TextInput::make('owner_email')
                        ->email()
                        ->required(),
                    TextInput::make('owner_email_notifications')
                        ->email()
                        ->required(),
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('address')
                        ->required(),
                ])->columns(1)
                ->extraAttributes(['class' => 'w-full mx-auto']);
        }

        // Si el usuario ya tiene un owner, solo muestra el formulario para la sucursal
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('address')
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): Branch
    {
        $user = auth()->user();

        // Verificar si el usuario tiene un owner_id
        if (is_null($user->owner_id)) {
            // Crear un nuevo registro en la tabla owner a partir de los datos del formulario
            $owner = Owner::create([
                'name' => $data['owner_name'],
                'address' => $data['owner_address'],
                'city' => $data['owner_city'],
                'state' => $data['owner_state'],
                'phone' => $data['owner_phone'],
                'alternate_phone' => $data['owner_alternate_phone'],
                'web_page' => $data['owner_web_page'],
                'email' => $data['owner_email'],
                'email_notifications' => $data['owner_email_notifications'],
                'user_id' => $user->id,
            ]);

            // Actualizar el owner_id del usuario
            $user->owner_id = $owner->id;
            $user->save();

            \Log::info('Se ha creado un nuevo owner con ID: ' . $owner->id);
        }

        // Crear la sucursal (branch) a partir de los datos del formulario
        $branch = Branch::create([
            'name' => $data['name'],
            'address' => $data['address']
        ]);

        // Asociar el usuario autenticado a la sucursal
        $branch->users()->attach($user);

        return $branch;
    }
}
