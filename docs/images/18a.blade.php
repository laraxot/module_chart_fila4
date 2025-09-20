@php
    use Filament\Forms\Components\Checkbox;
    use Filament\Forms\Components\TextInput;
    use Filament\Forms\Components\TimePicker;
    use Filament\Forms\Components\DatePicker;
    use Filament\Forms\Components\Section;
    use Filament\Forms\Components\Actions\Action;
    use Filament\Forms\Concerns\InteractsWithForms;
    use Filament\Forms\Contracts\HasForms;
    use Livewire\Volt\Component;
    
    new class extends Component implements HasForms {
        use InteractsWithForms;
        
        public $appointments = [
            [
                'name' => 'Nome Cognome',
                'date' => '2023-11-12',
                'time' => '16:00',
                'completed' => false
            ],
            [
                'name' => 'Nome Cognome',
                'date' => '2023-11-12',
                'time' => '17:00',
                'completed' => false
            ],
            [
                'name' => 'Nome Cognome',
                'date' => '2023-11-12',
                'time' => '18:00',
                'completed' => false
            ]
        ];
        
        public function render()
        {
            return view('livewire.appointments');
        }
    };
@endphp

<x-filament::page>
    <div class="space-y-6">
        <header>
            <h1 class="text-3xl font-bold text-gray-800">SALUTE ORALE</h1>
            <div class="h-1 w-20 bg-primary-500 mt-2"></div>
        </header>

        <x-filament::section heading="Appuntamenti accettati" icon="heroicon-o-calendar">
            <div class="space-y-4">
                @foreach($appointments as $index => $appointment)
                    <div class="border-l-4 border-primary-500 pl-4 py-2">
                        <x-filament::grid class="items-center">
                            <x-filament::grid.column>
                                {{ Checkbox::make("appointments.{$index}.completed")
                                    ->label($appointment['name'])
                                    ->inline()
                                }}
                                <p class="ml-8 text-gray-600">
                                    {{ \Carbon\Carbon::parse($appointment['date'])->translatedFormat('d F') }} - {{ $appointment['time'] }}
                                </p>
                            </x-filament::grid.column>
                            
                            <x-filament::grid.column class="flex justify-end">
                                <x-filament::button 
                                    icon="heroicon-o-document-text"
                                    color="primary"
                                    outlined
                                    tag="a"
                                    href="{{ route('filament.admin.resources.reports.create', ['appointment' => $index]) }}">
                                    Compila il referto
                                </x-filament::button>
                            </x-filament::grid.column>
                        </x-filament::grid>
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        <x-filament::section heading="RICHIESTE DI PRENOTAZIONE" icon="heroicon-o-inbox">
            <p class="text-gray-500 italic">Nessuna richiesta al momento</p>
        </x-filament::section>

        <x-filament::section heading="APPUNTAMENTI RIFIUTATI" icon="heroicon-o-x-circle">
            <p class="text-gray-500 italic">Nessun appuntamento rifiutato</p>
        </x-filament::section>
    </div>
</x-filament::page>

@push('styles')
    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23e5e7eb' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: moveBackground 20s linear infinite;
        }
        @keyframes moveBackground {
            0% { background-position: 0 0; }
            100% { background-position: 60px 60px; }
        }
    </style>
@endpush