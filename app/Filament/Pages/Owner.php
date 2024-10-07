<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use App\Models\Owner as OwnerModel;
use Filament\Actions;
use Filament\Notifications\Notification;

class Owner extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.owner';

    public ?array $data = [];

    public $owner;

    public function mount(): void
    {
        $this->owner = OwnerModel::find(auth()->user()->owner_id);
        $this->form->fill(
            $this->owner->attributesToArray()
        );
    }


    public function form(Form $form): Form
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
                TextInput::make('stripe_key')->maxLength(64),
                TextInput::make('stripe_secret')->maxLength(64),
                PhoneInput::make('phone'),
                PhoneInput::make('alternate_phone'),
            ])
            ->columns(4)
            ->statePath('data')
            ->model($this->owner);
    }


    //...
    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('Update')
                ->color('primary')
                ->submit('Update'),
        ];
    }

    public function update(): void
    {
        \Log::info("Update");

        $this->owner->update(
            $this->form->getState()
        );

        Notification::make()
            ->title('Profile updated!')
            ->success()
            ->send();
    }
}
