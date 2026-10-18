<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Models\Profile;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
                ->helperText('Shown on the profile, footer, and CV as the public contact address.')
                ->email()
                ->required(),
            Forms\Components\TextInput::make('phone'),
            Forms\Components\TextInput::make('website')->url(),
            Forms\Components\TextInput::make('blog_url')->url()->label('Blog URL'),
            Forms\Components\TextInput::make('github_url')->url(),
            Forms\Components\TextInput::make('linkedin_url')->url(),
            Forms\Components\TextInput::make('twitter_url')->url(),
            static::profilePhoto('photo_path', 'Who am I photo', 'Portrait in the whoami card. Also used when the profile is shared.'),
            static::profilePhoto('cv_photo_path', 'CV photo', 'Portrait on the HTML CV and the PDF download.'),
            static::profilePhoto('about_photo_path', 'About photo', 'Photograph in the About section. Leave empty to hide it.'),
        ]);
    }

    private static function profilePhoto(string $field, string $label, string $helper): Forms\Components\FileUpload
    {
        return Forms\Components\FileUpload::make($field)
            ->label($label)
            ->helperText($helper.'. A descriptive filename such as jane-doe-portrait.jpg is kept.')
            ->image()
            ->disk('public')
            ->directory('profile')
            ->visibility('public')
            ->fetchFileInformation(false)
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

                return ($name !== '' ? $name : 'profile-photo').'.'.strtolower($file->getClientOriginalExtension() ?: 'jpg');
            })
            ->getUploadedFileUsing(function (BaseFileUpload $component, string $file): ?array {
                $url = Profile::urlForPath($file);

                if ($url === null) {
                    return null;
                }

                return [
                    'name' => basename($file),
                    'size' => 0,
                    'type' => null,
                    'url' => $url,
                ];
            })
            ->columnSpanFull();
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
