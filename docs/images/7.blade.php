<?php
use Filament\Forms;
use App\Models\UserConsent;
use Livewire\Volt\Component;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public array $data = [];
    public UserConsent $consent;
    
    public function mount(): void
    {
        $this->consent = Auth::user() ? UserConsent::firstOrNew(['user_id' => Auth::id()]) : new UserConsent();
        $this->form->fill($this->consent->attributesToArray());
    }
    
    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Trattamento dati personali')
                    ->description('Informativa privacy ex art. 13 GDPR')
                    ->schema([
                        Forms\Components\RichEditor::make('privacy_text')
                            ->label('Testo Informativa Privacy')
                            ->default('Ai sensi del Regolamento (UE) 2016/679 del Parlamento europeo e del Consiglio del 27 aprile 2016 recante la disciplina europea per la protezione delle persone fisiche con riguardo al trattamento dei dati personali, nonché alla libera circolazione di tali dati (General Data Protection Regulation, nel prosieguo "GDPR"), e nel rispetto del decreto legislativo 30 giugno 2003, n. 196, così come novellato dal decreto legislativo 10 agosto 2018, n. 101, si informa che i dati personali forniti dai Soggetti proponenti progetti di ricerca e sviluppo nell\'ambito del decreto del Ministro dello sviluppo economico dell\'11 giugno 2020 e del decreto del Direttore generale della Direzione generale per gli incentivi alle imprese del 5 agosto 2020, formeranno oggetto di trattamento nel rispetto degli obblighi di riservatezza previsti dalla normativa sopra richiamata cui è tenuto il Ministero dello sviluppo economico - Direzione generale per gli incentivi alle imprese (nel prosieguo "DGIAI") in qualità di soggetto titolare della misura.')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                        
                        Checkbox::make('privacy_accepted')
                            ->label('Ho letto e accetto l\'informativa sulla privacy')
                            ->required()
                            ->columnSpanFull(),
                            
                        Checkbox::make('marketing_accepted')
                            ->label('Acconsento al trattamento dei miei dati per finalità di marketing')
                            ->columnSpanFull(),
                            
                        TextInput::make('ip_address')
                            ->label('Indirizzo IP')
                            ->default(request()->ip())
                            ->hidden()
                            ->dehydrated(),
                            
                        Forms\Components\Hidden::make('accepted_at')
                            ->default(now()->toDateTimeString())
                            ->dehydrated(),
                    ])
                    ->collapsible()
                    ->columns(1),
            ])
            ->statePath('data');
    }
    
    public function save(): void
    {
        $data = $this->form->getState();
        
        if (Auth::check()) {
            $this->consent->fill($data);
            $this->consent->user_id = Auth::id();
            $this->consent->save();
        } else {
            session(['privacy_consent' => $data]);
        }
        
        $this->redirect('/');
    }
}
?>

<x-filament-panels::page>
    <x-slot name="header">
        <div class="bg-blue-900 text-white p-4 w-full">
            <div class="container mx-auto flex justify-between items-center">
                <a href="#" class="text-3xl font-light">
                    <span class="font-normal">Salute</span> Ora<span class="italic">le</span>
                </a>
            </div>
        </div>
    </x-slot>
    
    <div class="max-w-3xl mx-auto mt-8">
        <form wire:submit="save">
            {{ $this->form }}
            
            <div class="mt-8 flex justify-center">
                <x-filament::button
                    type="submit"
                    size="{{ ActionSize::Large }}"
                    class="bg-blue-900 hover:bg-blue-800 uppercase px-8"
                >
                    Accetta e Continua
                </x-filament::button>
            </div>
        </form>
    </div>
    
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
        <svg class="absolute top-0 left-0 w-full opacity-5" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
            <path class="fill-blue-700" d="M539.8,137.6c55,8.2,106.7,34.3,149.1,69.9c46.5,39.2,83.2,89.8,97.6,147.3c15.7,62.8,4.3,129.5-22.8,187.6c-28.2,60.5-78.1,111.1-140.2,136.1c-55.8,22.4-119,26.3-177.6,12.1c-61.2-14.8-114.1-53.5-142.7-109.1C275.4,521.9,263,454.1,267,390c3.6-57.7,23.1-115.1,62.3-158.9c37.8-42.2,91.1-65.8,145.6-77.9C498.9,144.2,514.9,134.1,539.8,137.6z">
                <animate attributeName="d" dur="20s" repeatCount="indefinite" values="M539.8,137.6c55,8.2,106.7,34.3,149.1,69.9c46.5,39.2,83.2,89.8,97.6,147.3c15.7,62.8,4.3,129.5-22.8,187.6c-28.2,60.5-78.1,111.1-140.2,136.1c-55.8,22.4-119,26.3-177.6,12.1c-61.2-14.8-114.1-53.5-142.7-109.1C275.4,521.9,263,454.1,267,390c3.6-57.7,23.1-115.1,62.3-158.9c37.8-42.2,91.1-65.8,145.6-77.9C498.9,144.2,514.9,134.1,539.8,137.6z;
                M544.4,152.3c74.8,11.5,138.5,60.2,175.6,127.7c34.4,62.7,49.4,137.2,36.1,207.8c-12.3,65.1-48.5,124.9-103.1,162.6c-59.5,41-134.1,54.4-204.8,45.4c-64.6-8.2-128.8-37.2-166.1-91.4c-38.3-55.5-39.6-130.1-27.5-195.7c14-75.9,49.8-151.7,113.7-189.5c52.6-31.1,116.8-29.4,178.5-40.7c30-5.5,60.4-19.8,91.2-21.3c3.3-0.2,4.9-1.2,6.4,0.1z;
                M539.8,137.6c55,8.2,106.7,34.3,149.1,69.9c46.5,39.2,83.2,89.8,97.6,147.3c15.7,62.8,4.3,129.5-22.8,187.6c-28.2,60.5-78.1,111.1-140.2,136.1c-55.8,22.4-119,26.3-177.6,12.1c-61.2-14.8-114.1-53.5-142.7-109.1C275.4,521.9,263,454.1,267,390c3.6-57.7,23.1-115.1,62.3-158.9c37.8-42.2,91.1-65.8,145.6-77.9C498.9,144.2,514.9,134.1,539.8,137.6z">
                </animate>
            </path>
        </svg>
    </div>
</x-filament-panels::page>
