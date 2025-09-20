<x-filament::page>
    <x-volt::form wire:submit="searchDentists">
        <div class="space-y-6 max-w-xl mx-auto bg-white rounded-lg shadow-sm p-6">
            <header class="text-center mb-6">
                <h1 class="text-2xl font-bold text-primary-600">{{ __('Cerca un dentista') }}</h1>
                <p class="text-sm text-gray-500">{{ __('Compila il seguente modulo') }}</p>
            </header>

            <x-filament::section>
                {{ $this->schema }}
            </x-filament::section>

            <x-filament::button 
                type="submit"
                class="w-full justify-center"
                color="primary"
                size="lg"
            >
                {{ __('Cerca') }}
            </x-filament::button>
        </div>
    </x-volt::form>

    @if ($results)
        <x-filament::section class="mt-8">
            <livewire:dentists.search-results :results="$results" />
        </x-filament::section>
    @endif

    <x-laraxot::background-wave />
</x-filament::page>

<?php

use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;

use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\computed;

name('dentists.search');

state([
    'region' => null,
    'province' => null,
    'city' => null,
    'cap' => null,
    'results' => null,
]);

$regions = computed(function () {
    return \App\Models\Region::all()->pluck('name', 'id');
});

$provinces = computed(function () {
    if (!$this->region) return Collection::make();
    return \App\Models\Province::where('region_id', $this->region)
        ->orderBy('name')
        ->pluck('name', 'id');
});

$cities = computed(function () {
    if (!$this->province) return Collection::make();
    return \App\Models\City::where('province_id', $this->province)
        ->orderBy('name')
        ->pluck('name', 'id');
});

$caps = computed(function () {
    if (!$this->city) return Collection::make();
    return \App\Models\Cap::where('city_id', $this->city)
        ->orderBy('code')
        ->pluck('code', 'id');
});

$schema = [
    Select::make('region')
        ->label(__('Regione'))
        ->options(fn () => $this->regions)
        ->searchable()
        ->required()
        ->live()
        ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set) => $set('province', null))
        ->selectablePlaceholder(false),
    
    Select::make('province')
        ->label(__('Provincia'))
        ->options(fn () => $this->provinces)
        ->searchable()
        ->required()
        ->live()
        ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set) => $set('city', null))
        ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => filled($get('region')))
        ->selectablePlaceholder(false),
    
    Select::make('city')
        ->label(__('Città'))
        ->options(fn () => $this->cities)
        ->searchable()
        ->required()
        ->live()
        ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set) => $set('cap', null))
        ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => filled($get('province')))
        ->selectablePlaceholder(false),
    
    Select::make('cap')
        ->label(__('CAP'))
        ->options(fn () => $this->caps)
        ->searchable()
        ->required()
        ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => filled($get('city')))
        ->selectablePlaceholder(false),
];

function searchDentists()
{
    $this->validate();
    
    $this->results = \App\Models\Dentist::query()
        ->when($this->cap, fn ($query) => $query->where('cap_id', $this->cap))
        ->when($this->city && !$this->cap, fn ($query) => $query->whereHas('cap', fn ($q) => $q->where('city_id', $this->city)))
        ->with(['specializations', 'reviews'])
        ->orderBy('name')
        ->get();
        
    // Notify the user about the search results
    if ($this->results->isEmpty()) {
        Filament\Notifications\Notification::make()
            ->warning()
            ->title(__('Nessun risultato trovato'))
            ->body(__('Prova a modificare i criteri di ricerca'))
            ->send();
    } else {
        Filament\Notifications\Notification::make()
            ->success()
            ->title(__('Risultati trovati'))
            ->body(__(':count dentisti trovati', ['count' => $this->results->count()]))
            ->send();
    }
}
?>
