<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Pages\ViewDocument;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;

// use App\Filament\Resources\UserResource\RelationManagers;
// use App\Filament\Resources\UserResource\RelationManagers\RoleRelationManager;

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
        CheckboxList::make('roles')
          ->relationship('roles', 'name'),
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
        Tables\Columns\TextColumn::make('roles.name'),
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
      RolesRelationManager::class
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
