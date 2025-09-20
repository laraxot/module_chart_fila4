{{-- Utilizzo del layout Folio --}}
<x-layouts.app>
    {{-- Background SVG animato --}}
    <div class="fixed inset-0 z-0 overflow-hidden">
        <svg class="absolute top-0 left-0 w-full h-full opacity-5" viewBox="0 0 100 100" preserveAspectRatio="none">
            <circle class="floating-blob" cx="10" cy="10" r="20" fill="#0047AB" style="animation-delay: 0s;"></circle>
            <circle class="floating-blob" cx="90" cy="30" r="15" fill="#0047AB" style="animation-delay: 1s;"></circle>
            <circle class="floating-blob" cx="50" cy="70" r="25" fill="#0047AB" style="animation-delay: 2s;"></circle>
        </svg>
    </div>

    <div class="min-h-screen flex flex-col">
        <div class="flex-1 container mx-auto p-4 max-w-md md:max-w-2xl lg:max-w-4xl">
            <h1 class="text-2xl md:text-3xl text-blue-900 font-bold mb-8">{{ $title ?? 'Carica i documenti richiesti' }}</h1>
            
            <div class="space-y-6 md:space-y-8">
                {{-- Integrazione con Volt per reattività --}}
                <div x-data="{ 
                    isUploading: false, 
                    progress: 0,
                    uploadInProgress: false,
                    uploadSuccess: {},
                    init() {
                        this.$watch('uploadInProgress', value => {
                            if (value) {
                                this.simulateProgress();
                            }
                        });
                    },
                    simulateProgress() {
                        this.progress = 0;
                        const interval = setInterval(() => {
                            this.progress += 5;
                            if (this.progress >= 100) {
                                clearInterval(interval);
                                this.uploadInProgress = false;
                            }
                        }, 100);
                    }
                }">
                    {{-- Utilizzo componenti Filament --}}
                    <x-filament-panels::page class="!p-0">
                        {{-- Componente Form di Laraxot --}}
                        <x-laraxot::form wire:submit.prevent="submit">
                            {{ $this->form }}
                        </x-laraxot::form>
                        
                        {{-- Componenti per i file upload --}}
                        <div class="space-y-4">
                            {{-- Tessera Sanitaria Upload --}}
                            <div class="w-full bg-gray-300 hover:bg-gray-400 text-blue-900 font-bold py-4 px-6 rounded-full transition duration-300 ease-in-out relative overflow-hidden" 
                                @click="$refs.tesseraInput.click()" 
                                @dragover.prevent="$el.classList.add('bg-blue-100')" 
                                @dragleave.prevent="$el.classList.remove('bg-blue-100')" 
                                @drop.prevent="
                                    $el.classList.remove('bg-blue-100');
                                    $refs.tesseraInput.files = $event.dataTransfer.files;
                                    uploadInProgress = true;
                                "
                                :class="{ 'bg-blue-100': uploadInProgress && !uploadSuccess.tessera }">
                                <input 
                                    x-ref="tesseraInput" 
                                    type="file" 
                                    class="hidden" 
                                    wire:model="tessera_sanitaria" 
                                    accept="application/pdf,image/jpeg,image/png"
                                    @change="uploadInProgress = true"
                                />
                                <div class="flex items-center justify-between">
                                    <span>Carica tessera sanitaria, STP o ENI</span>
                                    <span x-show="uploadSuccess.tessera" class="text-green-600">
                                        <x-heroicon-o-check-circle class="w-6 h-6" />
                                    </span>
                                </div>
                                
                                {{-- Progress bar --}}
                                <div x-show="uploadInProgress && !uploadSuccess.tessera" class="absolute bottom-0 left-0 right-0 h-1 bg-blue-900" :style="`width: ${progress}%`"></div>
                            </div>
                            
                            {{-- ISEE Upload --}}
                            <div class="w-full bg-gray-300 hover:bg-gray-400 text-blue-900 font-bold py-4 px-6 rounded-full transition duration-300 ease-in-out relative overflow-hidden" 
                                @click="$refs.iseeInput.click()" 
                                @dragover.prevent="$el.classList.add('bg-blue-100')" 
                                @dragleave.prevent="$el.classList.remove('bg-blue-100')" 
                                @drop.prevent="
                                    $el.classList.remove('bg-blue-100');
                                    $refs.iseeInput.files = $event.dataTransfer.files;
                                    uploadInProgress = true;
                                "
                                :class="{ 'bg-blue-100': uploadInProgress && !uploadSuccess.isee }">
                                <input 
                                    x-ref="iseeInput" 
                                    type="file" 
                                    class="hidden" 
                                    wire:model="certificazione_isee" 
                                    accept="application/pdf,image/jpeg,image/png"
                                    @change="uploadInProgress = true"
                                />
                                <div class="flex items-center justify-between">
                                    <span>Carica autocertificazione livello ISEE</span>
                                    <span x-show="uploadSuccess.isee" class="text-green-600">
                                        <x-heroicon-o-check-circle class="w-6 h-6" />
                                    </span>
                                </div>
                                
                                {{-- Progress bar --}}
                                <div x-show="uploadInProgress && !uploadSuccess.isee" class="absolute bottom-0 left-0 right-0 h-1 bg-blue-900" :style="`width: ${progress}%`"></div>
                            </div>
                            
                            {{-- Attestazione di gravidanza Upload --}}
                            <div class="w-full bg-gray-300 hover:bg-gray-400 text-blue-900 font-bold py-4 px-6 rounded-full transition duration-300 ease-in-out relative overflow-hidden" 
                                @click="$refs.gravidanzaInput.click()" 
                                @dragover.prevent="$el.classList.add('bg-blue-100')" 
                                @dragleave.prevent="$el.classList.remove('bg-blue-100')" 
                                @drop.prevent="
                                    $el.classList.remove('bg-blue-100');
                                    $refs.gravidanzaInput.files = $event.dataTransfer.files;
                                    uploadInProgress = true;
                                "
                                :class="{ 'bg-blue-100': uploadInProgress && !uploadSuccess.gravidanza }">
                                <input 
                                    x-ref="gravidanzaInput" 
                                    type="file" 
                                    class="hidden" 
                                    wire:model="attestazione_gravidanza" 
                                    accept="application/pdf,image/jpeg,image/png"
                                    @change="uploadInProgress = true"
                                />
                                <div class="flex items-center justify-between">
                                    <span>Carica attestazione di gravidanza</span>
                                    <span x-show="uploadSuccess.gravidanza" class="text-green-600">
                                        <x-heroicon-o-check-circle class="w-6 h-6" />
                                    </span>
                                </div>
                                
                                {{-- Progress bar --}}
                                <div x-show="uploadInProgress && !uploadSuccess.gravidanza" class="absolute bottom-0 left-0 right-0 h-1 bg-blue-900" :style="`width: ${progress}%`"></div>
                            </div>
                        </div>
                        
                        {{-- Pulsante continua --}}
                        <x-filament::button 
                            type="submit" 
                            class="mt-10 w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-4 px-6 rounded-full pulse-button"
                            wire:click="submit">
                            CONTINUA
                        </x-filament::button>
                    </x-filament-panels::page>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

{{-- Livewire Component Class usando Folio Page --}}
@php
// Questo codice andrebbe nel relativo file Page di Folio
namespace App\Folio\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Laraxot\Core\Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

class CaricaDocumenti extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use WithFileUploads;
    
    // Proprietà Livewire per caricamento file
    public $tessera_sanitaria;
    public $certificazione_isee;
    public $attestazione_gravidanza;
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form->schema([
            // Utilizzo nascosto dei componenti form di Filament per la validazione
            Forms\Components\Hidden::make('tessera_sanitaria')
                ->maxSize(5120), // 5MB
            
            Forms\Components\Hidden::make('certificazione_isee')
                ->maxSize(5120),
            
            Forms\Components\Hidden::make('attestazione_gravidanza')
                ->maxSize(5120),
        ]);
    }
    
    public function submit(): void
    {
        // Validazione
        $this->validate([
            'tessera_sanitaria' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'certificazione_isee' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'attestazione_gravidanza' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        
        // Logica per salvare i file sul disco
        $paths = [];
        
        if ($this->tessera_sanitaria) {
            $paths['tessera_sanitaria'] = $this->tessera_sanitaria->store('documenti/tessere', 'public');
        }
        
        if ($this->certificazione_isee) {
            $paths['certificazione_isee'] = $this->certificazione_isee->store('documenti/isee', 'public');
        }
        
        if ($this->attestazione_gravidanza) {
            $paths['attestazione_gravidanza'] = $this->attestazione_gravidanza->store('documenti/gravidanza', 'public');
        }
        
        // Salva i path nel database usando il Model di Laraxot
        $documenti = app(\App\Models\Documento::class);
        $documenti->fill([
            'user_id' => auth()->id(),
            'paths' => $paths,
            'status' => 'pending'
        ]);
        $documenti->save();
        
        // Notifica
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Documenti caricati con successo'
        ]);
        
        // Reindirizza alla prossima pagina
        return redirect()->route('conferma-documenti');
    }
}
@endphp

{{-- CSS per animazioni --}}
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