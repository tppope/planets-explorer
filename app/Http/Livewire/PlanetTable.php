<?php

namespace App\Http\Livewire;

use App\Models\Planet;
use Illuminate\Database\Eloquent\Builder;
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
        $planets = Planet::all(['diameter', 'rotation_period', 'gravity']);
        $diameterOptions = $planets->pluck('diameter')->unique()->sort();
        $rotationPeriodOptions = $planets->pluck('rotation_period')->unique()->sort();
        $gravityOptions = $planets->pluck('gravity')->unique()->sort();

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
                ->sortable()->searchable(),
            Column::make('Rotation Period', 'rotation_period')
                ->sortable(),
            Column::make('Orbital Period', 'orbital_period')
                ->sortable(),
            Column::make('Diameter', 'diameter')
                ->sortable(),
            Column::make('Climate', 'climate')
                ->sortable(),
            Column::make('Gravity', 'gravity')
                ->sortable(),
            Column::make('Terrain', 'terrain')
                ->sortable(),
            Column::make('Surface Water', 'surface_water')
                ->sortable(),
            Column::make('Population', 'population')
                ->sortable(),
        ];
    }
}
