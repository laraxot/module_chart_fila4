
@php
    use Filament\Pages\Actions\Action;

    new class extends Component {
        public function render()
        {
            return view('livewire.request-detail');
        }

        protected function getActions(): array
        {
            return [
                Action::make('mark_paid')
                    ->label('SEGNA COME PAGATA')
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),
                
                Action::make('back')
                    ->label('TORNA ALL’ELENCO')
                    ->color('secondary')
                    ->icon('heroicon-o-arrow-left')
            ];
        }
    };
@endphp

<x-filament::page>
    <x-filament::card>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold">05/11/2024</h2>
                <p class="text-gray-600">ID: 2024121</p>
            </div>
        </div>
    </x-filament::card>

    <x-filament::actions :actions="$this->getActions()" class="mt-6 justify-end" />
</x-filament::page>