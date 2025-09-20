@php
$title = 'Salute Orale - Form Step 1';
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
    
    <main class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-blue-900 mb-4">Registrazione</h2>
            
            <div class="bg-gray-100 rounded-lg p-4 mb-6">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 rounded-full bg-blue-900 text-white flex items-center justify-center mr-3">1</div>
                    <span class="font-medium text-blue-900">Informazioni personali</span>
                </div>
                <div class="flex items-center mb-4 opacity-50">
                    <div class="w-8 h-8 rounded-full bg-gray-400 text-white flex items-center justify-center mr-3">2</div>
                    <span class="font-medium text-gray-500">Dichiarazione ISEE</span>
                </div>
                <div class="flex items-center opacity-50">
                    <div class="w-8 h-8 rounded-full bg-gray-400 text-white flex items-center justify-center mr-3">3</div>
                    <span class="font-medium text-gray-500">Conferma</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-xl font-semibold text-gray-800 mb-6">I tuoi dati</h1>
            
            <form wire:submit.prevent="submit">
                {{ $this->form }}
                
                <div class="mt-8 flex justify-between">
                    <x-filament::button
                        color="gray" 
                        tag="a" 
                        href="{{ route('home') }}"
                    >
                        Indietro
                    </x-filament::button>
                    
                    <x-filament::button type="submit">
                        Continua
                    </x-filament::button>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>

@php
// Questa classe viene definita nello stesso file solo per mostrare la struttura del form,
// in un'applicazione reale sarebbe in un file separato
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;

class RegistrationForm extends \Filament\Livewire\Component
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->label('Nome')
                    ->required(),
                
                TextInput::make('cognome')
                    ->label('Cognome')
                    ->required(),
                
                Select::make('tipo_documento')
                    ->label('Tipo documento')
                    ->options([
                        'ci' => 'Carta d\'identità',
                        'p' => 'Passaporto',
                        'ps' => 'Permesso di soggiorno',
                    ])
                    ->required(),
                
                TextInput::make('numero_documento')
                    ->label('Numero documento')
                    ->required(),
                
                DatePicker::make('data_nascita')
                    ->label('Data di nascita')
                    ->required(),
                
                TextInput::make('telefono')
                    ->label('Telefono')
                    ->tel()
                    ->required(),
                
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
            ])
            ->columns(1);
    }
    
    public function submit(): void
    {
        // Logica per il submit del form
    }
}
@endphp
