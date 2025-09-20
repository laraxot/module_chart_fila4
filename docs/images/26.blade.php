@php
    use Filament\Forms\Components\FileUpload;
    use Filament\Forms\Components\Actions;
    use Filament\Forms\Components\Actions\Action;
    use Livewire\Volt\Component;

    new class extends Component {
        public $attachments = [];

        protected function getFormSchema(): array
        {
            return [
                FileUpload::make('health_card')
                    ->label('Tessera sanitaria, STP o ENI')
                    ->acceptedFileTypes(['pdf', 'image/*'])
                    ->directory('health-cards')
                    ->columnSpanFull(),

                FileUpload::make('isee')
                    ->label('Autocertificazione ISEE')
                    ->acceptedFileTypes(['pdf'])
                    ->directory('isee-docs'),

                FileUpload::make('pregnancy_cert')
                    ->label('Attestazione di gravidanza')
                    ->acceptedFileTypes(['pdf', 'image/*'])
                    ->directory('pregnancy-certs'),

                Actions::make([
                    Action::make('accept')
                        ->label('ACCETTA')
                        ->color('success')
                        ->icon('heroicon-o-check')
                        ->action(fn () => $this->acceptDocuments()),

                    Action::make('reject')
                        ->label('RIFIUTA')
                        ->color('danger')
                        ->icon('heroicon-o-x')
                        ->action(fn () => $this->rejectDocuments())
                ])->fullWidth()
            ];
        }

        public function acceptDocuments()
        {
            // Logica accettazione documenti
        }

        public function rejectDocuments()
        {
            // Logica rifiuto documenti
        }
    };
@endphp

<x-filament::page>
    <x-filament::card>
        {{ $this->form }}
    </x-filament::card>
</x-filament::page>