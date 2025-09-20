<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <div class="flex-1 container mx-auto p-4 max-w-md md:max-w-2xl lg:max-w-4xl">
            <h1 class="text-2xl md:text-3xl text-blue-900 font-bold mb-8">Carica i documenti richiesti</h1>
            
            <div class="space-y-6 md:space-y-8">
                <x-filament::section>
                    {{-- Form con Filament --}}
                    <x-filament-panels::page>
                        <x-filament::card>
                            <form wire:submit="submit">
                                {{ $this->form }}
                                
                                <x-filament::button type="submit" class="mt-6 w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-4 px-6 rounded-full">
                                    CONTINUA
                                </x-filament::button>
                            </form>
                        </x-filament::card>
                    </x-filament-panels::page>
                </x-filament::section>
            </div>
        </div>
    </div>
</x-app-layout>

@php
// Questo codice andrebbe nel relativo file del form Filament
namespace App\Filament\Forms;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CaricaDocumentiForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('tessera_sanitaria')
                    ->label('Carica tessera sanitaria, STP o ENI')
                    ->disk('public')
                    ->directory('documenti/tessere')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(5120) // 5MB
                    ->buttonLabel('Seleziona file')
                    ->loadingIndicatorPosition('left')
                    ->removeButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->panelLayout('compact')
                    ->imagePreviewHeight('100')
                    ->columnSpanFull(),
                
                FileUpload::make('certificazione_isee')
                    ->label('Carica autocertificazione livello ISEE')
                    ->disk('public')
                    ->directory('documenti/isee')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(5120) // 5MB
                    ->buttonLabel('Seleziona file')
                    ->loadingIndicatorPosition('left')
                    ->removeButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->panelLayout('compact')
                    ->imagePreviewHeight('100')
                    ->columnSpanFull(),
                
                FileUpload::make('attestazione_gravidanza')
                    ->label('Carica attestazione di gravidanza')
                    ->disk('public')
                    ->directory('documenti/gravidanza')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(5120) // 5MB
                    ->buttonLabel('Seleziona file')
                    ->loadingIndicatorPosition('left')
                    ->removeButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->panelLayout('compact')
                    ->imagePreviewHeight('100')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        // Valida e salva i dati
        $data = $this->form->getState();
        
        // Logica per processare i file caricati
        // ...
        
        // Redirect alla pagina successiva
        redirect()->route('conferma-documenti');
    }

    public function render(): View
    {
        return view('livewire.carica-documenti-form');
    }
}
@endphp

@pushOnce('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script aggiuntivo per animazioni e interazioni UI
    });
</script>
@endPushOnce

@pushOnce('styles')
<style>
    .floating-blob {
        animation: float 8s ease-in-out infinite;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    
    .pulse-button {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endPushOnce