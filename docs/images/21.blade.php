
<x-app-layout>
    <div class="py-6 mx-auto">
        <div class="max-w-xl mx-auto">
            {{-- Header del contenuto --}}
            <x-filament::header>
                <x-slot name="heading">
                    <h1 class="text-3xl font-bold text-brand-blue">
                        Appuntamenti rifiutati
                    </h1>
                </x-slot>
            </x-filament::header>

            {{-- Lista appuntamenti rifiutati --}}
            <div x-data="{
                appointments: @js($appuntamentiRifiutati),
                initAnimation() {
                    this.appointments.forEach((appointment, index) => {
                        setTimeout(() => {
                            appointment.visible = true;
                        }, 100 * (index + 1));
                    });
                }
            }" 
            x-init="initAnimation()" 
            class="mt-6 space-y-4">
                @folio('components.AppointmentList', [
                    'title' => 'Appuntamenti rifiutati'
                ])

                <template x-for="(appointment, index) in appointments" :key="index">
                    <div 
                        x-show="appointment.visible" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="bg-white rounded-xl shadow p-4 flex items-center">
                        
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mr-4">
                            <span class="text-4xl text-gray-400" x-text="appointment.initial"></span>
                        </div>
                        
                        <div>
                            <h2 class="text-xl text-gray-500" x-text="appointment.name"></h2>
                            <p class="text-gray-400" x-text="appointment.date + ' - ' + appointment.time"></p>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Pulsanti azione --}}
            <div class="mt-8 space-y-4">
                <x-filament::button
                    wire:click="navigateToRequestsPage"
                    color="primary"
                    class="w-full justify-center rounded-full py-3"
                    tag="button">
                    RICHIESTE DI PRENOTAZIONE
                </x-filament::button>
                
                <x-filament::button
                    wire:click="navigateToAcceptedPage"
                    color="primary"
                    class="w-full justify-center rounded-full py-3"
                    tag="button">
                    APPUNTAMENTI ACCETTATI
                </x-filament::button>
            </div>
        </div>
    </div>

    {{-- SVG Background Animation --}}
    <div class="fixed bottom-0 left-0 w-full h-24 z-[-1] opacity-10">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
            <path fill="#004481" fill-opacity="1" d="M0,192L48,176C96,160,192,128,288,128C384,128,480,160,576,165.3C672,171,768,149,864,154.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                <animate attributeName="d" 
                    dur="10s"
                    repeatCount="indefinite"
                    values="
                        M0,192L48,176C96,160,192,128,288,128C384,128,480,160,576,165.3C672,171,768,149,864,154.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z;
                        M0,160L48,149.3C96,139,192,117,288,122.7C384,128,480,160,576,176C672,192,768,192,864,197.3C960,203,1056,213,1152,202.7C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z;
                        M0,192L48,176C96,160,192,128,288,128C384,128,480,160,576,165.3C672,171,768,149,864,154.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
                />
            </path>
        </svg>
    </div>
</x-app-layout>

@volt
class AppuntamentiRifiutati 
{
    public function mount()
    {
        $this->appuntamentiRifiutati = collect([
            [
                'id' => 1,
                'initial' => 'L',
                'name' => 'Nome Cognome',
                'date' => '12 Novembre',
                'time' => '15:30',
                'visible' => false,
            ],
            [
                'id' => 2,
                'initial' => 'E',
                'name' => 'Nome Cognome',
                'date' => '13 Novembre',
                'time' => '14:00',
                'visible' => false,
            ],
            [
                'id' => 3,
                'initial' => 'M',
                'name' => 'Nome Cognome',
                'date' => '13 Novembre',
                'time' => '17:30',
                'visible' => false,
            ],
            [
                'id' => 4,
                'initial' => 'A',
                'name' => 'Nome Cognome',
                'date' => '18 Novembre',
                'time' => '18:00',
                'visible' => false,
            ],
        ]);
    }

    public function navigateToRequestsPage()
    {
        return redirect()->route('appuntamenti.richieste');
    }

    public function navigateToAcceptedPage()
    {
        return redirect()->route('appuntamenti.accettati');
    }

    public function render()
    {
        return view('appuntamenti.rifiutati');
    }
}
@endvolt

{{-- Componente Folio per la lista appuntamenti --}}
@component('AppointmentList.php')
<?php

use function Livewire\Volt\{state};

$title = $title ?? 'Appuntamenti';

?>

<div>
    <h2 class="sr-only">{{ $title }}</h2>
</div>
@endcomponent

{{-- Resource in Laraxot --}}
@component('AppuntamentiResource.php')
<?php

namespace App\Filament\Resources;

use App\Models\Appuntamento;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class AppuntamentiResource extends Resource
{
    protected static ?string $model = Appuntamento::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Appuntamenti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome_paziente')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('data')
                    ->required(),
                Forms\Components\TimePicker::make('ora')
                    ->required(),
                Forms\Components\Select::make('stato')
                    ->options([
                        'richiesto' => 'Richiesto',
                        'accettato' => 'Accettato',
                        'rifiutato' => 'Rifiutato',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('note')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome_paziente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data')
                    ->date(),
                Tables\Columns\TextColumn::make('ora')
                    ->time(),
                Tables\Columns\BadgeColumn::make('stato')
                    ->colors([
                        'primary' => 'richiesto',
                        'success' => 'accettato',
                        'danger' => 'rifiutato',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stato')
                    ->options([
                        'richiesto' => 'Richiesto',
                        'accettato' => 'Accettato',
                        'rifiutato' => 'Rifiutato',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('accetta')
                    ->action(fn (Appuntamento $record) => $record->update(['stato' => 'accettato']))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn (Appuntamento $record) => $record->stato === 'richiesto'),
                Tables\Actions\Action::make('rifiuta')
                    ->action(fn (Appuntamento $record) => $record->update(['stato' => 'rifiutato']))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x')
                    ->visible(fn (Appuntamento $record) => $record->stato === 'richiesto'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppuntamenti::route('/'),
            'create' => Pages\CreateAppuntamento::route('/create'),
            'edit' => Pages\EditAppuntamento::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('data');
    }
}
@endcomponent