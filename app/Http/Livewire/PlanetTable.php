<?php

namespace App\Http\Livewire;

use App\Models\Planet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;

class PlanetTable extends DataTableComponent
{
    protected $model = Planet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setSingleSortingDisabled();
    }

    public function filters(): array
    {
        $planets = Planet::all(['diameter', 'rotation_period', 'gravity'])->toBase();
        $diameterOptions = $this->prepareOptions($planets->pluck('diameter'));
        $rotationPeriodOptions = $this->prepareOptions($planets->pluck('rotation_period'));
        $gravityOptions = $this->prepareOptions($planets->pluck('gravity'));

        return [
            MultiSelectDropdownFilter::make('Diameter')
                ->options(
                    $diameterOptions->combine($diameterOptions)->toArray()
                )->filter(function (Builder $builder, array $values) {
                    $values = collect($values);
                    if ($values->contains('- - -')) {
                        $builder->where('diameter', null);
                        $values = $values->reject(fn (string $value) => $value === '- - -');
                    }
                    $builder->orWhereIn('diameter', $values);
                }),
            MultiSelectDropdownFilter::make('Rotation Period')
                ->options(
                    $rotationPeriodOptions->combine($rotationPeriodOptions)->toArray()
                )->filter(function (Builder $builder, array $values) {
                    $values = collect($values);
                    if ($values->contains('- - -')) {
                        $builder->where('rotation_period', null);
                        $values = $values->reject(fn (string $value) => $value === '- - -');
                    }
                    $builder->orWhereIn('rotation_period', $values);
                }),
            MultiSelectDropdownFilter::make('Gravity')
                ->options(
                    $gravityOptions->combine($gravityOptions)->toArray()
                )->filter(function (Builder $builder, array $values) {
                    $values = collect($values);
                    if ($values->contains('- - -')) {
                        $builder->where('gravity', null);
                        $values = $values->reject(fn (string $value) => $value === '- - -');
                    }
                    $builder->orWhereIn('gravity', $values);
                }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable(),
            Column::make('Name', 'name')
                ->sortable()->searchable()->format($this->formatNullValue(...)),
            Column::make('Rotation Period', 'rotation_period')
                ->sortable()->format($this->formatNullValue(...)),
            Column::make('Orbital Period', 'orbital_period')
                ->sortable()->format($this->formatNullValue(...)),
            Column::make('Diameter', 'diameter')
                ->sortable()->format($this->formatNullValue(...)),
            Column::make('Climate', 'climate')
                ->sortable()->format($this->formatNullValue(...)),
            Column::make('Gravity', 'gravity')
                ->sortable()->format($this->formatNullValue(...)),
            Column::make('Terrain', 'terrain')
                ->sortable()->format($this->formatNullValue(...)),
            Column::make('Surface Water', 'surface_water')
                ->sortable()->format($this->formatNullValue(...)),
            Column::make('Population', 'population')
                ->sortable()->format($this->formatNullValue(...)),
        ];
    }

    private function prepareOptions(Collection $options): Collection
    {
        return $options->unique(strict: true)->map($this->formatNullValue(...))->sort();
    }

    private function formatNullValue($value): string
    {
        return $value ?? '- - -';
    }
}
