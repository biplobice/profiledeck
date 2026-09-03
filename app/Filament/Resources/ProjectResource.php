<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string|\UnitEnum|null $navigationGroup = 'Career';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\Select::make('company_id')->relationship('company', 'name')->searchable(),
            Forms\Components\Select::make('kind')->options(Project::kindLabels())->required(),
            Forms\Components\TextInput::make('role')->maxLength(255),
            Forms\Components\TextInput::make('url')->url()->maxLength(255),
            Forms\Components\DatePicker::make('started_on'),
            Forms\Components\DatePicker::make('ended_on'),
            Forms\Components\FileUpload::make('thumbnail_path')
                ->label('Thumbnail')
                ->helperText('Shown on the homepage card. Around 1200×750 works best; a monogram tile is used when empty.')
                ->image()
                ->imageEditor()
                ->disk('public')
                ->directory('projects')
                ->visibility('public')
                ->columnSpanFull(),
            Forms\Components\Textarea::make('summary')->columnSpanFull(),
            Forms\Components\TagsInput::make('responsibilities')->columnSpanFull(),
            Forms\Components\TagsInput::make('technologies')->columnSpanFull(),
            Forms\Components\Toggle::make('is_featured')
                ->label('Featured')
                ->helperText('Show on the homepage selected-work section and on the CV.'),
            Forms\Components\Toggle::make('is_visible')
                ->label('Display')
                ->helperText('Turn off to hide from the website and CV while keeping the record.')
                ->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_path')
                    ->label('')
                    ->getStateUsing(fn (Project $record) => $record->thumbnailUrl())
                    ->imageSize(44),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kind')->badge(),
                Tables\Columns\TextColumn::make('company.name'),
                Tables\Columns\ToggleColumn::make('is_featured')->label('Featured'),
                Tables\Columns\ToggleColumn::make('is_visible')->label('Display'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kind')->options(Project::kindLabels()),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
                Tables\Filters\TernaryFilter::make('is_visible')->label('Display'),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
