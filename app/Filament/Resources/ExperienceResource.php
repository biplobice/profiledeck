<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Models\Experience;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static string|\UnitEnum|null $navigationGroup = 'Career';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('company_id')->relationship('company', 'name')->required()->searchable(),
            Forms\Components\TextInput::make('title')->required()->maxLength(255),
            Forms\Components\TextInput::make('employment_type')->maxLength(255),
            Forms\Components\DatePicker::make('started_on')->required(),
            Forms\Components\DatePicker::make('ended_on'),
            Forms\Components\Textarea::make('summary')->columnSpanFull(),
            Forms\Components\TagsInput::make('responsibilities')->columnSpanFull(),
            Forms\Components\TagsInput::make('achievements')->columnSpanFull(),
            Forms\Components\Toggle::make('is_visible')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('started_on')->date('M Y')->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('company.name'),
                Tables\Columns\IconColumn::make('is_visible')->boolean(),
            ])
            ->defaultSort('started_on', 'desc')
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}
