
@php
    use Filament\Tables\Columns\TextColumn;
    use Filament\Tables\Columns\IconColumn;
    use Filament\Tables\Contracts\HasTable;
    use Livewire\Volt\Component;

    new class extends Component implements HasTable {
        use \Filament\Tables\Concerns\InteractsWithTable;

        protected function getTableQuery()
        {
            return \App\Models\Patient::query();
        }

        protected function getTableColumns(): array
        {
            return [
                TextColumn::make('badge')
                    ->label('')
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->color('primary'),

                TextColumn::make('full_name')
                    ->label('Paziente')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('appointment_date')
                    ->label('Data/Ora')
                    ->dateTime('d F - H:i'),

                IconColumn::make('actions')
                    ->icon('heroicon-o-eye')
                    ->action(fn ($record) => $this->viewPatient($record))
            ];
        }

        public function viewPatient($record)
        {
            return redirect()->route('filament.pages.patient-details', $record);
        }
    };
@endphp

<x-filament::page>
    <x-filament::card>
        <x-filament::table :columns="$this->getTableColumns()" />
        
        <div class="mt-4 border-t pt-4">
            <x-filament::button 
                color="primary" 
                outlined 
                wire:click="loadMore"
                class="w-full">
                Visualizza tutte le richieste
            </x-filament::button>
        </div>
    </x-filament::card>
</x-filament::page>