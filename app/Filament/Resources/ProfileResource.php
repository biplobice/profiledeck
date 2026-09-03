<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Models\Profile;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';

    protected static string|\UnitEnum|null $navigationGroup = 'Site';

    protected static ?string $navigationLabel = 'Profile';

    public static function canCreate(): bool
    {
        return Profile::query()->doesntExist();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('headline')->required(),
            Forms\Components\TextInput::make('tagline')
                ->helperText('Write :years to insert the current years of experience, counted from the oldest role.'),
            Forms\Components\Textarea::make('summary')
                ->helperText('Supports the :years placeholder.')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Textarea::make('bio')
                ->helperText('Supports the :years placeholder.')
                ->required()
                ->columnSpanFull(),
            Forms\Components\TextInput::make('location'),
            Forms\Components\TextInput::make('email')
                ->helperText('Used on the CV only. The website never renders it, to keep it away from scrapers.')
                ->email()
                ->required(),
            Forms\Components\TextInput::make('phone'),
            Forms\Components\TextInput::make('website')->url(),
            Forms\Components\TextInput::make('blog_url')->url()->label('Blog URL'),
            Forms\Components\TextInput::make('github_url')->url(),
            Forms\Components\TextInput::make('linkedin_url')->url(),
            Forms\Components\TextInput::make('twitter_url')->url(),
            Forms\Components\TextInput::make('photo_path'),
            Forms\Components\TextInput::make('cv_photo_path'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('headline'),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->recordActions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
