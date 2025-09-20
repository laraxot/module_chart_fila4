
@php
    use Filament\Forms\Components\TextInput;
    use Filament\Forms\Components\Section;

    new class extends Component {
        public $nome;
        public $cognome;
        public $indirizzo;
        public $citta;
        public $telefono;
        public $email;

        protected function getFormSchema(): array
        {
            return [
                Section::make('Dati anagrafici')
                    ->schema([
                        TextInput::make('nome')->required(),
                        TextInput::make('cognome')->required(),
                        TextInput::make('indirizzo')->required(),
                        TextInput::make('citta')->required(),
                        TextInput::make('telefono')->tel()->required(),
                        TextInput::make('email')->email()->required()
                    ])
            ];
        }
    };
@endphp

<x-filament::page>
    {{ $this->form }}
    
    <x-filament::button type="submit" color="primary" class="mt-6 w-full">
        CONTINUA
    </x-filament::button>
</x-filament::page>