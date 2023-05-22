<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static ?string $navigationIcon = 'heroicon-o-collection';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('name')
          ->required()
          ->maxLength(255),
        Forms\Components\TextInput::make('email')
          ->email()
          ->required()
          ->maxLength(255),
        // Forms\Components\DateTimePicker::make('email_verified_at'),
        Forms\Components\TextInput::make('password')
          ->password()
          ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
          ->maxLength(255)
          ->minLength(8)
          ->dehydrated(fn ($state) => filled($state))
          ->dehydrateStateUsing(fn ($state) => Hash::make($state))
          ->same('passwordConfirmation'),
        Forms\Components\TextInput::make('passwordConfirmation')
          ->label('Password Confirmation')
          ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
          ->minLength(8)
          ->dehydrated(false)
          ->password(),
        Forms\Components\Toggle::make('is_admin')
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('name'),
        Tables\Columns\TextColumn::make('email'),
        // Tables\Columns\TextColumn::make('email_verified_at')
        //   ->dateTime(),
        Tables\Columns\IconColumn::make('is_admin')
          ->boolean(),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime(),
        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
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
      'index' => Pages\ListUsers::route('/'),
      'create' => Pages\CreateUser::route('/create'),
      'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }
}
