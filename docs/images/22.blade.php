
@php
    use Filament\Tables\Columns\TextColumn;
    use Filament\Tables\Columns\ColorColumn;

    new class extends Component {
        protected function getTableColumns(): array
        {
            return [
                TextColumn::make('id')
                    ->label('ID Richiesta'),
                
                ColorColumn::make('status')
                    ->colors([
                        'danger' => 'Insoluta',
                        'success' => 'Pagata',
                    ])
            ];
        }

        protected function getActions(): array
        {
            return [
                Action::make('home')
                    ->label('TORNA ALLA HOMEPAGE')
                    ->color('secondary')
            ];
        }
    };
@endphp

<x-filament::page>
    <x-filament::card>
        <x-filament::table :columns="$this->getTableColumns()" />
        <x-filament::actions :actions="$this->getActions()" class="mt-8" />
    </x-filament::card>
</x-filament::page>