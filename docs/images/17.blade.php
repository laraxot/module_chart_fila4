<?php

use Illuminate\Support\Facades\Route;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AppointmentRequests extends Component
{
    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Appointment::query()->where('status', 'pending'))
            ->columns([
                Tables\Columns\ImageColumn::make('patient.profile_image')
                    ->circular()
                    ->defaultImageUrl(function (Appointment $record): string {
                        return 'https://ui-avatars.com/api/?name=' . urlencode($record->patient->name) . '&color=fff&background=004785';
                    }),
                Tables\Columns\TextColumn::make('patient.name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),
                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('Data')
                    ->date('d F')
                    ->sortable(),
                Tables\Columns\TextColumn::make('appointment_time')
                    ->label('Ora')
                    ->time('H:i')
                    ->sortable(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('accept')
                    ->label('Accetta')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (Appointment $record) {
                        $record->status = 'accepted';
                        $record->save();
                        
                        Notification::make()
                            ->title('Appuntamento accettato')
                            ->success()
                            ->send();
                    })
                    ->button()
                    ->outlined(),
                \Filament\Actions\Action::make('reject')
                    ->label('Rifiuta')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(function (Appointment $record) {
                        $record->status = 'rejected';
                        $record->save();
                        
                        Notification::make()
                            ->title('Appuntamento rifiutato')
                            ->warning()
                            ->send();
                    })
                    ->button()
                    ->outlined(),
            ])
            ->defaultSort('appointment_date', 'asc')
            ->toolbarActions([])
            ->contentGrid([
                'md' => 1,
                'xl' => 1,
            ])
            ->emptyStateHeading('Nessuna richiesta di prenotazione')
            ->emptyStateDescription('Al momento non ci sono nuove richieste di prenotazione da gestire.')
            ->emptyStateIcon('heroicon-o-calendar');
    }

    public function acceptedAppointmentsAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('acceptedAppointments')
            ->label('Appuntamenti Accettati')
            ->url(route('appointments.accepted'))
            ->buttonLabel('APPUNTAMENTI ACCETTATI')
            ->button()
            ->color('primary')
            ->size('xl')
            ->block();
    }

    public function rejectedAppointmentsAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('rejectedAppointments')
            ->label('Appuntamenti Rifiutati')
            ->url(route('appointments.rejected'))
            ->buttonLabel('APPUNTAMENTI RIFIUTATI')
            ->button()
            ->color('primary')
            ->size('xl')
            ->block();
    }
}

?>

<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <header class="bg-blue-900 text-white p-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-2xl font-light">
                <span class="font-normal">SALUTE</span> <span class="font-light">ORA<span class="italic">le</span></span>
            </a>
            
            <x-filament::icon-button
                icon="heroicon-o-bars-3"
                label="Menu"
                x-data="{}"
                x-on:click="$dispatch('open-sidebar')"
                class="text-white"
            />
        </header>

        <div class="container mx-auto px-4 py-8">
            <h1 class="text-blue-900 text-3xl font-bold mb-8">Richieste di prenotazione</h1>
            
            @livewire('volt:appointment-requests')
            
            <div class="mt-8 space-y-4">
                @livewire('appointment-requests::accepted-appointments-action')
                @livewire('appointment-requests::rejected-appointments-action')
            </div>
        </div>
        
        <!-- Animated SVG Background -->
        <div class="fixed bottom-0 left-0 w-full h-64 z-[-1] opacity-5 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#004785" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,176C960,171,1056,181,1152,192C1248,203,1344,213,1392,218.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    <animate 
                        attributeName="d" 
                        dur="10s" 
                        repeatCount="indefinite" 
                        values="
                            M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,176C960,171,1056,181,1152,192C1248,203,1344,213,1392,218.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z;
                            M0,160L48,149.3C96,139,192,117,288,128C384,139,480,181,576,197.3C672,213,768,203,864,186.7C960,171,1056,149,1152,160C1248,171,1344,213,1392,234.7L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z;
                            M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,176C960,171,1056,181,1152,192C1248,203,1344,213,1392,218.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
                    />
                </path>
            </svg>
        </div>
    </div>
</x-app-layout>
