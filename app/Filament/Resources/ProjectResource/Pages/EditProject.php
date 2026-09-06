<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Database\Query\Builder;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->neighbourAction('previous'),
            $this->neighbourAction('next'),
            Actions\DeleteAction::make(),
        ];
    }

    protected function neighbourAction(string $direction): Actions\Action
    {
        $isPrevious = $direction === 'previous';
        $neighbour = $this->neighbour($isPrevious);

        return Actions\Action::make($direction)
            ->label($isPrevious ? 'Previous' : 'Next')
            ->icon($isPrevious ? Heroicon::ArrowLeft : Heroicon::ArrowRight)
            ->iconPosition($isPrevious ? IconPosition::Before : IconPosition::After)
            ->color('gray')
            ->tooltip($neighbour?->name)
            ->disabled($neighbour === null)
            ->url($neighbour ? static::getResource()::getUrl('edit', ['record' => $neighbour]) : null);
    }

    /**
     * Walks the table's default order, using the primary key to break ties on
     * the many projects that share a sort_order.
     */
    protected function neighbour(bool $isPrevious): ?Project
    {
        $record = $this->getRecord();
        $comparison = $isPrevious ? '<' : '>';
        $direction = $isPrevious ? 'desc' : 'asc';

        return Project::query()
            ->where(fn (Builder $query) => $query
                ->where('sort_order', $comparison, $record->sort_order)
                ->orWhere(fn (Builder $query) => $query
                    ->where('sort_order', $record->sort_order)
                    ->where($record->getKeyName(), $comparison, $record->getKey())))
            ->orderBy('sort_order', $direction)
            ->orderBy($record->getKeyName(), $direction)
            ->first();
    }
}
