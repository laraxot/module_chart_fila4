
@php
    use Filament\Forms\Components\Radio;
    use Filament\Forms\Components\Textarea;
    use Filament\Forms\Components\Section;
    use Filament\Forms\Components\Actions\Action;
    use Filament\Forms\Concerns\InteractsWithForms;
    use Filament\Forms\Contracts\HasForms;
    use Livewire\Volt\Component;

    new class extends Component implements HasForms {
        use InteractsWithForms;

        public $reason = '';
        public $notes = '';

        protected function getFormSchema(): array 
        {
            return [
                Section::make('Motivazione del rifiuto appuntamento')
                    ->schema([
                        Radio::make('reason')
                            ->options([
                                'agenda' => 'Conflitto d\'agenda (disponibile in altro orario)',
                                'closure' => 'Chiusura straordinaria (disponibile in altra data)',
                                'service' => 'Non fornisce il servizio (non più disponibile)'
                            ])
                            ->required()
                            ->columns(1)
                            ->disableOptionWhen(fn (string $value): bool => $value === 'service'),
                            
                        Textarea::make('notes')
                            ->label('Note aggiuntive')
                            ->placeholder('Inserisci eventuali dettagli...')
                            ->rows(3)
                            ->hidden(fn (\Closure $get) => $get('reason') !== 'other')
                    ])
                    ->compact()
            ];
        }

        public function submit()
        {
            $this->validate();
            // Logica di invio
        }

        public function render()
        {
            return view('livewire.reject-appointment');
        }
    };
@endphp

<x-filament::page>
    <div class="space-y-6">
        <header>
            <h1 class="text-3xl font-bold text-gray-800">SALUTE ORALE</h1>
            <div class="h-1 w-20 bg-danger-500 mt-2"></div>
        </header>

        {{ $this->form }}

        <x-filament::button 
            color="danger"
            icon="heroicon-o-x-circle"
            size="lg"
            wire:click="submit">
            Conferma Rifiuto
        </x-filament::button>
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