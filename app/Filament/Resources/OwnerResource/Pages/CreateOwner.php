<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;
    protected ?string $heading = 'Crear Compañia';

    public static function canCreate(): bool
    {
        return false;
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }
}
