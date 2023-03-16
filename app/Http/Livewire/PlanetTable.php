<?php

namespace App\Http\Livewire;

use App\Models\Planet;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

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
        return [
            SelectFilter::make('Active')
                ->options([
                    '' => 'All',
                    'yes' => 'Yes',
                    'no' => 'No',
                ]),
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
