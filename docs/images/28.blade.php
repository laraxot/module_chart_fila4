
@php
    use Filament\Forms\Components\Repeater;
    use Filament\Forms\Components\TextInput;
    use Filament\Forms\Components\Actions;
    use Livewire\Volt\Component;

    new class extends Component {
        public $studios = [
            [
                'name' => 'Studio Odontoiatrico 1',
                'address' => 'Via Malapelli 9B, 00042 Roma'
            ],
            // Altri studi...
        ];

        protected function getFormSchema(): array
        {
            return [
                Repeater::make('studios')
                    ->label('Studi disponibili')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Studio')
                            ->required(),

                        TextInput::make('address')
                            ->label('Indirizzo')
                            ->required()
                    ])
                    ->defaultItems(3)
                    ->createItemButtonLabel('Aggiungi Studio')
                    ->collapsible(),

                Actions::make([
                    Actions\Action::make('view')
                        ->label('Visualizza')
                        ->icon('heroicon-o-eye')
                        ->color('primary')
                        ->url(fn ($record) => route('studio.details', $record))
                ])
            ];
        }
    };
@endphp

<x-filament::page>
    <x-filament::card>
        <x-filament::form :schema="$this->getFormSchema()" />
    </x-filament::card>
</x-filament::page>