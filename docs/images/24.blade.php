
@php
    use Filament\Tables\Columns\TextColumn;
    use Filament\Tables\Columns\IconColumn;

    new class extends Component {
        public function render()
        {
            return view('livewire.patient-registrations');
        }

        protected function getTableColumns(): array
        {
            return [
                TextColumn::make('badge')
                    ->label('')
                    ->formatStateUsing(fn ($state) => strtoupper($state)),
                
                TextColumn::make('nome')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('data')
                    ->date('d F - H:i'),
                
                IconColumn::make('actions')
                    ->icon('heroicon-o-eye')
                    ->action(fn ($record) => $this->viewDetails($record))
            ];
        }
    };
@endphp

<x-filament::page>
    <x-filament::card>
        <x-filament::table :columns="$this->getTableColumns()" />
        
        <div class="p-4 border-t">
            <x-filament::button color="primary" outlined wire:click="loadAll">
                Visualizza tutte le richieste
            </x-filament::button>
        </div>
    </x-filament::card>
</x-filament::page>