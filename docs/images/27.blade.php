
@php
    use Filament\Forms\Components\Actions;
    use Filament\Forms\Components\FileUpload;

    new class extends Component {
        public $documents = [];

        protected function getFormSchema(): array
        {
            return [
                FileUpload::make('health_card')
                    ->label('Tessera Sanitaria')
                    ->acceptedFileTypes(['pdf', 'image/*']),
                
                FileUpload::make('isee')
                    ->label('Autocertificazione ISEE'),
                
                FileUpload::make('pregnancy')
                    ->label('Attestazione Gravidanza'),
                
                Actions::make([
                    Action::make('accept')
                        ->label('ACCETTA')
                        ->color('success'),
                    
                    Action::make('reject')
                        ->label('RIFIUTA')
                        ->color('danger')
                ])->fullWidth()
            ];
        }
    };
@endphp

<x-filament::page>
    <x-filament::card>
        {{ $this->form }}
    </x-filament::card>
</x-filament::page>