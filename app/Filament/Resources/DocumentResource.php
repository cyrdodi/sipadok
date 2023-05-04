<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Type;
use Filament\Tables;
use App\Models\Document;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DocumentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DocumentResource\RelationManagers;

class DocumentResource extends Resource
{
  protected static ?string $model = Document::class;

  protected static ?string $navigationIcon = 'heroicon-o-collection';

  public static function form(Form $form): Form
  {
    $current_year = date("Y");
    $start_year = $current_year - 5;

    $years = array();
    for ($year = $start_year; $year <= $current_year; $year++) {
      $years[$year] = $year;
    }

    // dd($years);
    return $form
      ->schema([
        Forms\Components\TextInput::make('name')
          ->required()
          ->maxLength(255)
          ->label('Nama Dokumen'),
        Forms\Components\TextInput::make('description')
          ->required()
          ->maxLength(255)
          ->label('Deskripsi'),
        Forms\Components\Select::make('type_id')
          ->options(Type::all()->pluck('name', 'id'))
          ->required()
          ->label('Tipe'),
        Forms\Components\Select::make('year')
          ->options($years)
          ->required()
          ->label('Tahun'),
        Forms\Components\TagsInput::make('tags')
          ->required(),
        Forms\Components\TextInput::make('link')
          ->required()
          ->maxLength(255),
      ]);
  }

  public function isTableSearchable(): bool
  {
    return true;
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('name')
          ->searchable(),
        Tables\Columns\TextColumn::make('description')
          ->searchable(),
        Tables\Columns\TextColumn::make('type.name'),
        Tables\Columns\TextColumn::make('year')
          ->searchable(),
        // Tables\Columns\TextColumn::make('user.name'),
        Tables\Columns\TextColumn::make('tags'),
        // Tables\Columns\TextColumn::make('link'),
        // Tables\Columns\TextColumn::make('created_at')
        //   ->dateTime(),
        // Tables\Columns\TextColumn::make('updated_at')
        //   ->dateTime(),
      ])
      ->filters([
        SelectFilter::make('type_id')
          ->options(Type::all()->pluck('name', 'id'))
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\Action::make('Link')
          ->url(fn (Document $record): string => url($record->link))
          ->openUrlInNewTab()
      ])
      ->bulkActions([
        Tables\Actions\DeleteBulkAction::make(),
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
      'index' => Pages\ListDocuments::route('/'),
      'create' => Pages\CreateDocument::route('/create'),
      'edit' => Pages\EditDocument::route('/{record}/edit'),
    ];
  }
}
