<?php

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Facades\FilamentView;
use Illuminate\View\Component;
use Livewire\Component as Volt;
use Laravel\Folio\Folio;
use Laraxot\Module;

class AvailabilityScheduleForm extends Component implements HasForms
{
    use InteractsWithForms;

    public $availabilityData = [
        'monday' => [
            'enabled' => false,
            'start_time' => null,
            'end_time' => null,
        ],
        'tuesday' => [
            'enabled' => false,
            'start_time' => null,
            'end_time' => null,
        ],
        'wednesday' => [
            'enabled' => false,
            'start_time' => null,
            'end_time' => null,
        ],
        'thursday' => [
            'enabled' => false,
            'start_time' => null,
            'end_time' => null,
        ],
        'friday' => [
            'enabled' => false,
            'start_time' => null,
            'end_time' => null,
        ],
        'saturday' => [
            'enabled' => false,
            'start_time' => null,
            'end_time' => null,
        ],
    ];

    public function mount(): void
    {
        $this->form->fill([
            'availabilityData' => $this->availabilityData,
        ]);
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        $this->createDayScheduleFields('monday', 'Lunedì'),
                        $this->createDayScheduleFields('tuesday', 'Martedì'),
                        $this->createDayScheduleFields('wednesday', 'Mercoledì'),
                        $this->createDayScheduleFields('thursday', 'Giovedì'),
                        $this->createDayScheduleFields('friday', 'Venerdì'),
                        $this->createDayScheduleFields('saturday', 'Sabato'),
                    ])
                    ->columns(1),
            ])
            ->statePath('formData');
    }

    protected function createDayScheduleFields(string $day, string $label): \Filament\Schemas\Components\Grid
    {
        return \Filament\Schemas\Components\Grid::make()
            ->schema([
                Checkbox::make("availabilityData.{$day}.enabled")
                    ->label($label)
                    ->live()
                    ->afterStateUpdated(function ($state, $livewire) use ($day) {
                        if (!$state) {
                            $livewire->data("availabilityData.{$day}.start_time", null);
                            $livewire->data("availabilityData.{$day}.end_time", null);
                        }
                    }),
                    
                \Filament\Schemas\Components\Grid::make()
                    ->schema([
                        TimePicker::make("availabilityData.{$day}.start_time")
                            ->label('Dalle')
                            ->seconds(false)
                            ->displayFormat('H:i')
                            ->hidden(fn (callable $get) => !$get("availabilityData.{$day}.enabled"))
                            ->required(fn (callable $get) => $get("availabilityData.{$day}.enabled")),
                            
                        TimePicker::make("availabilityData.{$day}.end_time")
                            ->label('Alle')
                            ->seconds(false)
                            ->displayFormat('H:i')
                            ->hidden(fn (callable $get) => !$get("availabilityData.{$day}.enabled"))
                            ->required(fn (callable $get) => $get("availabilityData.{$day}.enabled"))
                            ->afterOrEqual(fn (callable $get) => $get("availabilityData.{$day}.start_time")),
                    ])
                    ->columns(2)
                    ->columnSpan(3),
            ])
            ->columns(4);
    }

    public function copyToAllDays()
    {
        // Find the first day that has time settings
        foreach ($this->availabilityData as $day => $settings) {
            if ($settings['enabled'] && $settings['start_time'] && $settings['end_time']) {
                $template = $settings;
                
                // Apply to all other days
                foreach ($this->availabilityData as $targetDay => $targetSettings) {
                    $this->availabilityData[$targetDay] = $template;
                }
                
                $this->form->fill([
                    'availabilityData' => $this->availabilityData,
                ]);
                
                return;
            }
        }
    }

    public function copyToWeekdays()
    {
        // Find the first weekday that has time settings
        $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        foreach ($weekdays as $day) {
            if ($this->availabilityData[$day]['enabled'] && 
                $this->availabilityData[$day]['start_time'] && 
                $this->availabilityData[$day]['end_time']) {
                
                $template = $this->availabilityData[$day];
                
                // Apply to all weekdays
                foreach ($weekdays as $targetDay) {
                    $this->availabilityData[$targetDay] = $template;
                }
                
                $this->form->fill([
                    'availabilityData' => $this->availabilityData,
                ]);
                
                return;
            }
        }
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        
        // Process the form data
        // Qui inserisci la logica per salvare i dati degli orari
        
        // Emit saved event or redirect
        $this->dispatch('availability-saved');
    }

    public function render()
    {
        return view('components.availability-schedule-form');
    }
}

?>

<x-layouts.app>
    <div class="relative min-h-screen flex flex-col items-center justify-start p-4">
        <!-- SVG Background Animation -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
            <x-dynamic-component 
                component="animated-background" 
                baseColor="#003d73" 
                accentColor="#00509e" 
            />
        </div>
        
        <!-- Header -->
        <div class="w-full flex justify-between items-center py-4 px-2 mb-6">
            <x-salute-orale-logo class="h-12 text-white" />
            <x-dropdown>
                <x-slot name="trigger">
                    <button class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </x-slot>
                
                <x-dropdown.item href="{{ route('dashboard') }}">Dashboard</x-dropdown.item>
                <x-dropdown.item href="{{ route('profile') }}">Profilo</x-dropdown.item>
                <x-dropdown.item href="{{ route('settings') }}">Impostazioni</x-dropdown.item>
                <x-dropdown.item href="{{ route('logout') }}">Logout</x-dropdown.item>
            </x-dropdown>
        </div>
        
        <!-- Form Title -->
        <div class="w-full max-w-3xl mb-4">
            <h2 class="text-2xl font-medium text-blue-900">
                Imposta i tuoi orari di disponibilità
            </h2>
        </div>
        
        <!-- Availability Form Container -->
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">
            <livewire:volt is="availability-schedule-form">
                <x-filament-forms::form wire:submit="submit">
                    {{ $this->form }}
                    
                    <div class="flex flex-col sm:flex-row gap-4 mt-6">
                        <x-filament::button 
                            wire:click="copyToWeekdays" 
                            color="secondary"
                            size="sm"
                            class="justify-center"
                        >
                            Copia sui giorni feriali
                        </x-filament::button>
                        
                        <x-filament::button 
                            wire:click="copyToAllDays" 
                            color="secondary"
                            size="sm"
                            class="justify-center"
                        >
                            Applica a tutti i giorni
                        </x-filament::button>
                        
                        <x-filament::button 
                            type="submit" 
                            color="primary"
                            class="justify-center ml-auto"
                            size="lg"
                        >
                            Salva
                        </x-filament::button>
                    </div>
                </x-filament-forms::form>
            </livewire:volt>
        </div>
    </div>
</x-layouts.app>
