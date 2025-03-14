<?php

namespace App\Filament\Submonitoring\Resources\UserResource\Pages;

use App\createpage;
use App\Filament\Submonitoring\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    use createpage;
}
