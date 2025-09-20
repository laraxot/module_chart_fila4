@php
$title = 'Salute Orale - Modulo di Iscrizione';
@endphp

<x-app-layout :title="$title">
    <header class="bg-blue-900 text-white p-4 flex justify-between items-center">
        <div class="text-3xl font-light">
            <span class="font-normal">SALUTE</span> ORA<span class="italic font-light text-2xl">le</span>
        </div>
        <button class="text-white" aria-label="Menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>
    
    <main class="max-w-lg mx-auto p-6">
        <h1 class="text-2xl font-medium text-blue-900 mb-8">Compila il seguente modulo per iscriverti</h1>
        
        <x-filament-panels::form wire:submit="submit">
            {{ $this->form }}
            
            <div class="mt-8">
                <x-filament::button 
                    type="submit"
                    color="primary" 
                    class="w-full rounded-full text-lg font-medium py-3 px-6"
                >
                    CONTINUA
                </x-filament::button>
            </div>
        </x-filament-panels::form>
    </main>
</x-app-layout>

@php
// Questa classe viene definita nello stesso file solo per mostrare la struttura del form,
// in un'applicazione reale sarebbe in un file separato

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class RegistrationForm extends \Filament\Livewire\Component
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->placeholder('Nome')
                    ->required()
                    ->autofocus()
                    ->extraInputAttributes([
                        'class' => 'rounded-full px-4 py-3',
                    ]),
                
                TextInput::make('cognome')
                    ->placeholder('Cognome')
                    ->required()
                    ->extraInputAttributes([
                        'class' => 'rounded-full px-4 py-3',
                    ]),
                
                TextInput::make('indirizzo')
                    ->placeholder('Indirizzo')
                    ->required()
                    ->extraInputAttributes([
                        'class' => 'rounded-full px-4 py-3',
                    ]),
                
                TextInput::make('citta')
                    ->placeholder('Città')
                    ->required()
                    ->extraInputAttributes([
                        'class' => 'rounded-full px-4 py-3',
                    ]),
                
                TextInput::make('telefono')
                    ->placeholder('Numero di telefono')
                    ->tel()
                    ->required()
                    ->extraInputAttributes([
                        'class' => 'rounded-full px-4 py-3',
                    ]),
                
                TextInput::make('email')
                    ->placeholder('Email')
                    ->email()
                    ->required()
                    ->extraInputAttributes([
                        'class' => 'rounded-full px-4 py-3',
                    ]),
            ])
            ->columns(1);
    }
    
    public function submit(): void
    {
        // Logica per il submit del form
    }
}
@endphp

@push('styles')
<style>
    .form-input {
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .form-input:focus {
        box-shadow: 0 0 0 2px rgba(0, 76, 135, 0.2);
    }
    
    .filament-button {
        transition: all 0.2s ease-in-out;
    }
    
    .filament-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .filament-button:active {
        transform: translateY(0);
    }
</style>
@endpush
