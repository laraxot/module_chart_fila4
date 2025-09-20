{{-- Utilizzo del layout Folio --}}
<x-layouts.app>
    {{-- Background SVG animato --}}
    <div class="fixed inset-0 z-0 overflow-hidden">
        <svg class="absolute top-0 left-0 w-full h-full opacity-5" viewBox="0 0 100 100" preserveAspectRatio="none">
            <!-- Stylized tooth shapes -->
            <path class="floating-tooth" d="M20,20 Q25,15 30,20 Q35,25 30,30 Q25,35 20,30 Q15,25 20,20" fill="#0047AB" style="animation-delay: 0s;"></path>
            <path class="floating-tooth" d="M70,30 Q75,25 80,30 Q85,35 80,40 Q75,45 70,40 Q65,35 70,30" fill="#0047AB" style="animation-delay: 1.5s;"></path>
            <path class="floating-tooth" d="M30,60 Q35,55 40,60 Q45,65 40,70 Q35,75 30,70 Q25,65 30,60" fill="#0047AB" style="animation-delay: 2.5s;"></path>
        </svg>
    </div>

    <div class="min-h-screen flex flex-col">
        <div class="flex-1 container mx-auto p-4 max-w-md md:max-w-2xl lg:max-w-4xl">
            <h1 class="text-2xl md:text-3xl text-blue-900 font-bold mb-8">{{ $title ?? 'Alcune informazioni preventive alla visita' }}</h1>
            
            <div class="space-y-6 md:space-y-8">
                {{-- Integrazione con Volt per reattività --}}
                <div x-data="{ 
                    ultima_visita: '', 
                    showDatePicker: false,
                    isPredefinedSelected: false,
                    selezionePersonalizzata: false,
                    opzioniPredefinite: [
                        { label: 'Mai', value: 'mai' },
                        { label: 'Negli ultimi 6 mesi', value: 'ultimi_6_mesi' },
                        { label: 'Più di 6 mesi fa', value: 'piu_6_mesi' },
                        { label: 'Più di 1 anno fa', value: 'piu_1_anno' },
                        { label: 'Più di 2 anni fa', value: 'piu_2_anni' },
                        { label: 'Inserisci data esatta', value: 'personalizzata' }
                    ],
                    validate() {
                        return this.ultima_visita !== '' || (this.selezionePersonalizzata && this.$refs.datePicker.value !== '');
                    }
                }">
                    {{-- Utilizzo componenti Filament --}}
                    <x-filament-panels::page class="!p-0">
                        {{-- Form di input utilizzando Laraxot --}}
                        <x-laraxot::form wire:submit.prevent="submit">
                            {{-- Selezione rapida --}}
                            <div x-show="!selezionePersonalizzata" class="mb-4">
                                <x-filament::input.wrapper>
                                    <x-filament::input
                                        type="text" 
                                        id="ultima_visita_field"
                                        x-model="ultima_visita"
                                        wire:model="ultima_visita" 
                                        placeholder="Qual è l'ultima volta che è andata dal dentista?"
                                        class="w-full px-6 py-4 text-gray-500 bg-white rounded-full shadow-md focus:ring-2 focus:ring-blue-900"
                                        x-on:click="isPredefinedSelected ? null : showDatePicker = true"
                                        readonly
                                    />
                                </x-filament::input.wrapper>
                                
                                {{-- Opzioni predefinite con dropdown --}}
                                <div 
                                    x-show="showDatePicker" 
                                    x-transition
                                    class="mt-2 bg-white rounded-lg shadow-lg border border-gray-100 p-2 absolute z-10 w-full md:w-auto">
                                    <div class="space-y-2">
                                        <template x-for="opzione in opzioniPredefinite" :key="opzione.value">
                                            <div 
                                                class="px-4 py-2 hover:bg-blue-50 rounded-md cursor-pointer transition-colors"
                                                x-on:click="
                                                    if(opzione.value === 'personalizzata') {
                                                        selezionePersonalizzata = true;
                                                        showDatePicker = false;
                                                    } else {
                                                        ultima_visita = opzione.label;
                                                        showDatePicker = false;
                                                        isPredefinedSelected = true;
                                                    }
                                                "
                                                x-text="opzione.label">
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Data picker per selezione personalizzata --}}
                            <div x-show="selezionePersonalizzata" class="mb-4">
                                <x-filament::input.wrapper
                                    label="Seleziona la data esatta dell'ultima visita">
                                    <x-filament-forms::field-wrapper>
                                        <x-filament::input.wrapper>
                                            <x-filament-forms::date-time-picker
                                                x-ref="datePicker"
                                                wire:model="data_ultima_visita"
                                                :display-format="'d/m/Y'"
                                                :max="now()"
                                                :firstDayOfWeek="1"
                                                class="w-full rounded-full"
                                            />
                                        </x-filament::input.wrapper>
                                        
                                        <div class="mt-2">
                                            <button 
                                                type="button"
                                                x-on:click="
                                                    selezionePersonalizzata = false;
                                                    showDatePicker = false;
                                                    ultima_visita = '';
                                                    isPredefinedSelected = false;
                                                "
                                                class="text-sm text-blue-900 hover:underline">
                                                Torna alle opzioni predefinite
                                            </button>
                                        </div>
                                    </x-filament-forms::field-wrapper>
                                </x-filament::input.wrapper>
                            </div>
                            
                            {{-- Click away per chiudere dropdown --}}
                            <div
                                x-show="showDatePicker"
                                x-on:click.away="showDatePicker = false"
                                class="fixed inset-0 z-0 bg-transparent">
                            </div>
                            
                            {{-- Pulsante continua --}}
                            <x-filament::button 
                                type="submit" 
                                class="mt-10 w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-4 px-6 rounded-full pulse-button"
                                wire:click="submit"
                                x-bind:disabled="!validate()">
                                CONTINUA
                            </x-filament::button>
                        </x-laraxot::form>
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
use Illuminate\Support\Carbon;

class InformazioniPreventive extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    
    // Proprietà Livewire
    public $ultima_visita = '';
    public $data_ultima_visita = null;
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('ultima_visita')
                ->label('Ultima visita dal dentista')
                ->placeholder('Qual è l\'ultima volta che è andata dal dentista?')
                ->required(),
                
            Forms\Components\DatePicker::make('data_ultima_visita')
                ->label('Data ultima visita')
                ->maxDate(now())
                ->displayFormat('d/m/Y')
                ->closeOnDateSelection(),
        ]);
    }
    
    public function submit(): void
    {
        // Valida i dati
        $data = $this->form->getState();
        
        // Prepara i dati da salvare
        $info = [
            'ultima_visita' => $this->ultima_visita,
            'data_esatta' => $this->data_ultima_visita ? Carbon::parse($this->data_ultima_visita)->format('Y-m-d') : null
        ];
        
        // Salva i dati nella sessione per i passaggi successivi
        session(['informazioni_preventive' => $info]);
        
        // Salva nel database se necessario
        if (auth()->check()) {
            $paziente = auth()->user()->paziente;
            if ($paziente) {
                $paziente->ultima_visita_dentista = $info['ultima_visita'];
                $paziente->data_ultima_visita = $info['data_esatta'];
                $paziente->save();
            }
        }
        
        // Notifica
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Informazioni salvate con successo'
        ]);
        
        // Reindirizza alla prossima pagina
        return redirect()->route('questionario-anamnesi');
    }
    
    public function render(): View
    {
        return view('folio.pages.informazioni-preventive');
    }
}
@endphp

{{-- CSS per animazioni --}}
@pushOnce('styles')
<style>
    .floating-tooth {
        animation: float 8s ease-in-out infinite;
    }
    
    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(5deg); }
        100% { transform: translateY(0px) rotate(0deg); }
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