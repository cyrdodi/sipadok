<?php

namespace App\Filament\Resources\DocumentResource\Widgets;

use App\Models\Document;
use App\Models\Type;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
  protected function getCards(): array
  {
    $types = Type::all();

    $cards = [];
    $cards[] = Card::make('Jumlah Dokumen', Document::count());
    foreach ($types as $type) {
      $cards[] = Card::make($type->name, $type->documents->count());
    }

    return
      $cards;
  }
}
