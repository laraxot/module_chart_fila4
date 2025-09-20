<?php

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Facades\FilamentView;
use Illuminate\View\Component;
use Livewire\Component as Volt;
use Laravel\Folio\Folio;
use Laraxot\Module;

class RegistrationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public $ragioneSociale = '';
    public $indirizzo = '';
    public $citta = '';
    public $cap = '';
    public $telefono = '';
    public $email = '';
    public $iban = '';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                TextInput::make('ragioneSociale')
                    ->label('')
                    ->placeholder('Ragione Sociale')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                TextInput::make('indirizzo')
                    ->label('')
                    ->placeholder('Indirizzo')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                TextInput::make('citta')
                    ->label('')
                    ->placeholder('Città')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                TextInput::make('cap')
                    ->label('')
                    ->placeholder('CAP')
                    ->required()
                    ->maxLength(5)
                    ->minLength(5)
                    ->numeric()
                    ->columnSpanFull(),
                
                TextInput::make('telefono')
                    ->label('')
                    ->placeholder('Numero di telefono')
                    ->tel()
                    ->required()
                    ->maxLength(20)
                    ->columnSpanFull(),
                
                TextInput::make('email')
                    ->label('')
                    ->placeholder('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                TextInput::make('iban')
                    ->label('')
                    ->placeholder('IBAN')
                    ->required()
                    ->maxLength(34)
                    ->columnSpanFull(),
            ])
            ->statePath('data')
            ->enableAnimation()
            ->inlineLabel(false)
            ->columns(1);
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        
        // Process the form data
        // Qui inserisci la logica per salvare i dati
        
        // Redirect to the next step
        $this->redirect(route('registration.success'));
    }

    public function render()
    {
        return view('components.registration-form');
    }
}

?>

<x-layouts.app>
    <div class="relative min-h-screen flex flex-col items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
        <!-- SVG Background Animation -->
        <div class="fixed inset-0 z-0 overflow-hidden">
            <x-dynamic-component 
                component="animated-background" 
                baseColor="#003d73" 
                accentColor="#00509e" 
            />
        </div>
        
        <!-- Header -->
        <div class="w-full max-w-md mb-6 sm:mb-8">
            <x-salute-orale-logo class="h-12 text-white" />
        </div>
        
        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-xl w-full max-w-xl p-6 sm:p-8">
            <h2 class="text-xl sm:text-2xl font-medium text-blue-900 mb-6">
                Compila il seguente modulo per completare l'iscrizione
            </h2>
            
            <livewire:volt is="registration-form">
                <x-filament-forms::form wire:submit="submit">
                    {{ $this->form }}
                    
                    <div class="mt-6">
                        <x-filament::button 
                            type="submit" 
                            color="primary"
                            class="w-full justify-center py-3 uppercase"
                            size="lg"
                        >
                            Continua
                        </x-filament::button>
                    </div>
                </x-filament-forms::form>
            </livewire:volt>
        </div>
    </div>
</x-layouts.app>
