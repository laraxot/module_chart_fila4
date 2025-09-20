
@php
    use Filament\Tables\Columns\TextColumn;
    use Filament\Tables\Columns\BadgeColumn;

    new class extends Component {
        protected function getTableColumns(): array
        {
            return [
                TextColumn::make('id')
                    ->label('ID')
                    ->fontFamily('monospace'),
                
                BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'Insoluta',
                        'success' => 'Pagata',
                    ])
                    ->enum([
                        'Insoluta' => 'Insoluta',
                        'Pagata' => 'Pagata',
                    ])
            ];
        }
    };
@endphp

<x-filament::page>
    <x-filament::card>
        <x-filament::table :columns="$this->getTableColumns()" />
    </x-filament::card>
</x-filament::page>