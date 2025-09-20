<x-filament::page>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-primary-600">{{ __('Gli Studi Odontoiatrici più vicini a te') }}</h1>
        
        <x-filament::section class="mt-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    {{ $this->resultsCount }} {{ trans_choice('risultato|risultati', $this->resultsCount) }} per: 
                    <span class="font-medium">{{ $this->searchLocation }}</span>
                </div>
                
                <x-filament::button
                    color="gray"
                    icon="heroicon-m-funnel"
                    x-on:click="$dispatch('open-modal', { id: 'filter-modal' })"
                >
                    {{ __('Filtri') }}
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>
    
    <div class="space-y-4">
        @forelse($this->dentistClinics as $clinic)
            <x-filament::section>
                <div @class([
                    'flex flex-col lg:flex-row lg:items-center lg:justify-between',
                    'gap-4'
                ])>
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-primary-600">{{ $clinic->name }}</h2>
                        <div class="text-gray-500">{{ $clinic->full_address }}</div>
                        
                        @if($this->showDetails)
                            <div class="mt-2 flex items-center text-sm">
                                <x-filament::badge color="gray">
                                    <x-slot:icon>
                                        <x-heroicon-s-map-pin class="h-4 w-4" />
                                    </x-slot:icon>
                                    {{ $clinic->distance_formatted }}
                                </x-filament::badge>
                                
                                <div class="ml-3 flex items-center">
                                    <x-heroicon-s-star class="h-4 w-4 text-amber-500" />
                                    <span class="ml-1">{{ $clinic->rating }} ({{ $clinic->reviews_count }})</span>
                                </div>
                            </div>
                            
                            <div class="mt-2 text-sm">
                                @foreach($clinic->specializations as $specialization)
                                    <x-filament::badge>{{ $specialization->name }}</x-filament::badge>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        <x-filament::button
                            wire:click="openBookingModal({{ $clinic->id }})"
                            color="primary"
                            icon="heroicon-m-calendar"
                            size="lg"
                            class="whitespace-nowrap"
                        >
                            {{ __('Prenota') }}
                        </x-filament::button>
                        
                        @if(!$this->showDetails)
                            <x-filament::link 
                                wire:click="viewDetails({{ $clinic->id }})"
                                color="primary"
                                class="block mt-2 text-center"
                            >
                                {{ __('Visualizza dettagli') }}
                            </x-filament::link>
                        @endif
                    </div>
                </div>
            </x-filament::section>
        @empty
            <x-filament::section>
                <div class="text-center py-6">
                    <x-heroicon-o-face-frown class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-lg font-medium text-gray-900">{{ __('Nessuno studio trovato') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Prova a modificare i filtri di ricerca') }}</p>
                    
                    <div class="mt-6">
                        <x-filament::button
                            wire:click="resetFilters"
                            color="primary"
                        >
                            {{ __('Reimposta filtri') }}
                        </x-filament::button>
                    </div>
                </div>
            </x-filament::section>
        @endforelse
    </div>
    
    @if($this->dentistClinics->hasPages())
        <div class="mt-4">
            {{ $this->dentistClinics->links() }}
        </div>
    @endif
    
    <x-filament::modal id="filter-modal" width="md">
        <x-slot name="heading">
            {{ __('Filtra risultati') }}
        </x-slot>
        
        <x-slot name="description">
            {{ __('Affina la tua ricerca usando i filtri disponibili') }}
        </x-slot>
        
        <x-volt::form wire:submit="applyFilters">
            {{ $this->filterForm }}
            
            <x-slot name="footer">
                <div class="flex justify-between gap-x-4">
                    <x-filament::button
                        wire:click="resetFilters"
                        color="gray"
                    >
                        {{ __('Reimposta') }}
                    </x-filament::button>
                    
                    <x-filament::button type="submit">
                        {{ __('Applica filtri') }}
                    </x-filament::button>
                </div>
            </x-slot>
        </x-volt::form>
    </x-filament::modal>
    
    <x-filament::modal id="booking-modal" width="lg">
        <x-slot name="heading">
            {{ __('Prenota appuntamento') }}
        </x-slot>
        
        <x-slot name="description">
            @if($this->selectedClinic)
                {{ __('Prenota un appuntamento presso') }}: {{ $this->selectedClinic->name }}
            @endif
        </x-slot>
        
        @if($this->selectedClinic)
            <livewire:dentists.booking-form :clinic="$this->selectedClinic" />
        @endif
    </x-filament::modal>
    
    <x-laraxot::background-wave />
</x-filament::page>

<?php

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RangeSlider;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

use function Laravel\Folio\name;
use function Livewire\Volt\computed;
use function Livewire\Volt\mount;
use function Livewire\Volt\state;

name('dentists.search-results');

state([
    'searchParams' => null,
    'filters' => [
        'distance' => 10,
        'rating' => 0,
        'specializations' => [],
        'availableToday' => false,
        'hasParking' => false,
    ],
    'showDetails' => false,
    'detailsClinicId' => null,
    'selectedClinic' => null,
]);

// Mount function to initialize component with search parameters
mount(function ($searchParams = null) {
    $this->searchParams = $searchParams ?? session('last_dentist_search');
    
    if (!$this->searchParams) {
        return redirect()->route('dentists.search');
    }
    
    session(['last_dentist_search' => $this->searchParams]);
});

// Computed property for clinics with pagination
$dentistClinics = computed(function () {
    return \App\Models\DentistClinic::query()
        ->when($this->searchParams['cap'] ?? null, function (Builder $query) {
            $query->where('cap', $this->searchParams['cap']);
        })
        ->when($this->searchParams['city'] ?? null, function (Builder $query) {
            $query->where('city_id', $this->searchParams['city']);
        })
        ->when($this->filters['distance'] < 50, function (Builder $query) {
            // Apply distance filter using the user's location
            $query->withinDistanceOf(
                'location',
                $this->searchParams['latitude'],
                $this->searchParams['longitude'],
                $this->filters['distance']
            );
        })
        ->when($this->filters['rating'] > 0, function (Builder $query) {
            $query->where('rating', '>=', $this->filters['rating']);
        })
        ->when(!empty($this->filters['specializations']), function (Builder $query) {
            $query->whereHas('specializations', function ($query) {
                $query->whereIn('id', $this->filters['specializations']);
            });
        })
        ->when($this->filters['availableToday'], function (Builder $query) {
            $query->whereHas('availabilities', function ($query) {
                $query->whereDate('date', now()->toDateString());
            });
        })
        ->when($this->filters['hasParking'], function (Builder $query) {
            $query->where('has_parking', true);
        })
        ->with(['specializations', 'reviews'])
        ->withCount('reviews')
        ->orderByDistanceFrom(
            'location',
            $this->searchParams['latitude'],
            $this->searchParams['longitude']
        )
        ->paginate(10);
});

// Count of results
$resultsCount = computed(function () {
    return $this->dentistClinics->total();
});

// Search location formatted
$searchLocation = computed(function () {
    if (isset($this->searchParams['cap'])) {
        return $this->searchParams['cap'] . ' ' . ($this->searchParams['city_name'] ?? '');
    }
    
    return $this->searchParams['city_name'] ?? __('la tua posizione');
});

// Available specializations for filter
$availableSpecializations = computed(function() {
    return \App\Models\Specialization::orderBy('name')->pluck('name', 'id');
});

// Form schema for filters
$filterForm = [
    RangeSlider::make('filters.distance')
        ->label(__('Distanza massima'))
        ->minValue(1)
        ->maxValue(50)
        ->step(1)
        ->suffix('km')
        ->helperText(__('Mostra solo gli studi entro questa distanza')),
        
    Select::make('filters.rating')
        ->label(__('Valutazione minima'))
        ->options([
            0 => __('Tutte le valutazioni'),
            3 => __('3+ stelle'),
            4 => __('4+ stelle'),
            4.5 => __('4.5+ stelle'),
        ]),
        
    Select::make('filters.specializations')
        ->label(__('Specializzazioni'))
        ->options(fn() => $this->availableSpecializations)
        ->multiple()
        ->searchable(),
        
    Toggle::make('filters.availableToday')
        ->label(__('Disponibile oggi'))
        ->inline(false),
        
    Toggle::make('filters.hasParking')
        ->label(__('Con parcheggio'))
        ->inline(false),
];

function resetFilters()
{
    $this->filters = [
        'distance' => 10,
        'rating' => 0,
        'specializations' => [],
        'availableToday' => false,
        'hasParking' => false,
    ];
    
    $this->applyFilters();
}

function applyFilters()
{
    // Just call to refresh the results
    $this->dispatch('close-modal', id: 'filter-modal');
}

function viewDetails($clinicId)
{
    if ($this->detailsClinicId === $clinicId) {
        $this->showDetails = !$this->showDetails;
    } else {
        $this->detailsClinicId = $clinicId;
        $this->showDetails = true;
    }
}

function openBookingModal($clinicId)
{
    $this->selectedClinic = \App\Models\DentistClinic::find($clinicId);
    $this->dispatch('open-modal', id: 'booking-modal');
}
?>