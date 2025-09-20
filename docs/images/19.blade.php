
<?php

use function Livewire\Volt\{state, computed};
use Illuminate\Support\Facades\Route;
use Filament\Forms;
use Filament\Tables;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;

// Define the route using Folio
Route::get('/appointments', function () {
    return view('appointments');
})->name('appointments.index');

?>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-blue-900 leading-tight">
                {{ __('Richieste di prenotazione') }}
            </h2>
            <x-filament::button icon="heroicon-o-calendar" class="ml-4">
                {{ __('Calendario') }}
            </x-filament::button>
        </div>
    </x-slot>

    @volt
    <div>
        <?php
        // State management with Volt
        state([
            'appointments' => fn() => \App\Models\Appointment::where('status', AppointmentStatus::PENDING)->get(),
            'selectedAppointment' => null,
            'isDetailModalOpen' => false,
            'confirmingAppointment' => null,
            'rejectReason' => '',
            'isRejectModalOpen' => false,
            'filter' => 'all'
        ]);

        // Computed properties with Volt
        $filteredAppointments = computed(function() {
            if ($this->filter === 'all') {
                return $this->appointments;
            }
            return $this->appointments->filter(
                fn($appointment) => $appointment->status === $this->filter
            );
        });

        // Actions
        $openDetailModal = function($id) {
            $this->selectedAppointment = \App\Models\Appointment::find($id);
            $this->isDetailModalOpen = true;
        };

        $closeDetailModal = function() {
            $this->isDetailModalOpen = false;
            $this->selectedAppointment = null;
        };

        $confirmAppointment = function($id) {
            $appointment = \App\Models\Appointment::find($id);
            $appointment->status = AppointmentStatus::ACCEPTED;
            $appointment->save();

            // Update local state
            $this->appointments = \App\Models\Appointment::where('status', AppointmentStatus::PENDING)->get();

            Notification::make()
                ->title('Appuntamento confermato')
                ->success()
                ->send();
        };

        $openRejectModal = function($id) {
            $this->confirmingAppointment = \App\Models\Appointment::find($id);
            $this->isRejectModalOpen = true;
        };

        $rejectAppointment = function() {
            $this->confirmingAppointment->status = AppointmentStatus::REJECTED;
            $this->confirmingAppointment->rejection_reason = $this->rejectReason;
            $this->confirmingAppointment->save();

            // Update local state
            $this->appointments = \App\Models\Appointment::where('status', AppointmentStatus::PENDING)->get();
            $this->isRejectModalOpen = false;
            $this->rejectReason = '';
            $this->confirmingAppointment = null;

            Notification::make()
                ->title('Appuntamento rifiutato')
                ->warning()
                ->send();
        };
        ?>

        <!-- Mobile View -->
        <div class="mt-4 space-y-4 md:hidden">
            @foreach($this->filteredAppointments as $appointment)
                <div class="bg-white rounded-xl shadow-md p-4">
                    <div class="flex items-center">
                        <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300 mr-4">
                            <span class="text-4xl text-blue-900 font-bold">{{ substr($appointment->patient->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl text-blue-900 font-bold">{{ $appointment->patient->name }} {{ $appointment->patient->surname }}</h2>
                            <p class="text-gray-500">{{ $appointment->appointment_date->format('d F') }} - {{ $appointment->appointment_time->format('H:i') }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button wire:click="confirmAppointment({{ $appointment->id }})" class="w-12 h-12 bg-green-100 rounded-md flex items-center justify-center">
                                <x-heroicon-o-check class="w-8 h-8 text-green-600" />
                            </button>
                            <button wire:click="openRejectModal({{ $appointment->id }})" class="w-12 h-12 bg-red-100 rounded-md flex items-center justify-center">
                                <x-heroicon-o-x-mark class="w-8 h-8 text-red-400" />
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-8 space-y-4">
                <a href="{{ route('appointments.accepted') }}" class="bg-blue-900 text-white w-full py-4 rounded-full font-bold text-xl block text-center">
                    APPUNTAMENTI ACCETTATI
                </a>
                <a href="{{ route('appointments.rejected') }}" class="bg-blue-900 text-white w-full py-4 rounded-full font-bold text-xl block text-center">
                    APPUNTAMENTI RIFIUTATI
                </a>
            </div>
        </div>

        <!-- Desktop View -->
        <div class="hidden md:block">
            {{ 
                \Filament\Tables\Table::make()
                    ->query(\App\Models\Appointment::query()->where('status', AppointmentStatus::PENDING))
                    ->columns([
                        TextColumn::make('patient.name')
                            ->label('Nome')
                            ->searchable()
                            ->sortable(),
                        TextColumn::make('patient.surname')
                            ->label('Cognome')
                            ->searchable()
                            ->sortable(),
                        TextColumn::make('appointment_date')
                            ->label('Data')
                            ->date('d F Y')
                            ->sortable(),
                        TextColumn::make('appointment_time')
                            ->label('Ora')
                            ->time('H:i')
                            ->sortable(),
                        TextColumn::make('service.name')
                            ->label('Servizio')
                            ->sortable(),
                        IconColumn::make('is_new_patient')
                            ->label('Nuovo Paziente')
                            ->boolean(),
                    ])
                    ->filters([
                        SelectFilter::make('service_id')
                            ->relationship('service', 'name')
                            ->label('Servizio'),
                        SelectFilter::make('is_new_patient')
                            ->options([
                                '1' => 'Nuovi Pazienti',
                                '0' => 'Pazienti Esistenti',
                            ])
                            ->label('Tipo Paziente'),
                    ])
                    ->actions([
                        Action::make('view')
                            ->label('Dettagli')
                            ->icon('heroicon-o-eye')
                            ->action(fn ($record) => $this->openDetailModal($record->id)),
                        Action::make('accept')
                            ->label('Accetta')
                            ->icon('heroicon-o-check')
                            ->color('success')
                            ->action(fn ($record) => $this->confirmAppointment($record->id)),
                        Action::make('reject')
                            ->label('Rifiuta')
                            ->icon('heroicon-o-x-mark')
                            ->color('danger')
                            ->action(fn ($record) => $this->openRejectModal($record->id)),
                    ])
                    ->bulkActions([
                        Tables\Actions\BulkAction::make('acceptAll')
                            ->label('Accetta Selezionati')
                            ->action(function (Collection $records) {
                                foreach ($records as $record) {
                                    $record->status = AppointmentStatus::ACCEPTED;
                                    $record->save();
                                }
                                
                                $this->appointments = \App\Models\Appointment::where('status', AppointmentStatus::PENDING)->get();
                                
                                Notification::make()
                                    ->title(count($records) . ' appuntamenti accettati')
                                    ->success()
                                    ->send();
                            })
                            ->requiresConfirmation()
                            ->deselectRecordsAfterCompletion()
                    ])
            }}
        </div>

        <!-- Detail Modal -->
        <x-filament::modal :open="$isDetailModalOpen" width="lg">
            <x-slot name="heading">
                Dettagli Appuntamento
            </x-slot>

            <x-slot name="description">
                @if($selectedAppointment)
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                                <x-heroicon-o-user class="w-8 h-8 text-blue-900" />
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">{{ $selectedAppointment->patient->name }} {{ $selectedAppointment->patient->surname }}</h3>
                                <p class="text-sm text-gray-500">{{ $selectedAppointment->patient->email }}</p>
                                <p class="text-sm text-gray-500">{{ $selectedAppointment->patient->phone }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Data</h4>
                                <p>{{ $selectedAppointment->appointment_date->format('d F Y') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Ora</h4>
                                <p>{{ $selectedAppointment->appointment_time->format('H:i') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Servizio</h4>
                                <p>{{ $selectedAppointment->service->name }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Durata</h4>
                                <p>{{ $selectedAppointment->service->duration }} minuti</p>
                            </div>
                        </div>

                        @if($selectedAppointment->notes)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Note</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedAppointment->notes }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-filament::button color="gray" wire:click="closeDetailModal">
                        Chiudi
                    </x-filament::button>
                    <x-filament::button color="danger" wire:click="openRejectModal({{ $selectedAppointment?->id ?? 0 }})">
                        Rifiuta
                    </x-filament::button>
                    <x-filament::button color="success" wire:click="confirmAppointment({{ $selectedAppointment?->id ?? 0 }})">
                        Accetta
                    </x-filament::button>
                </div>
            </x-slot>
        </x-filament::modal>

        <!-- Reject Modal -->
        <x-filament::modal :open="$isRejectModalOpen" width="md">
            <x-slot name="heading">
                Rifiuta Appuntamento
            </x-slot>

            <x-slot name="description">
                <div class="space-y-4">
                    <p>Sei sicuro di voler rifiutare questo appuntamento?</p>
                    
                    <x-filament::input.wrapper>
                        <x-filament::input.label for="rejectReason">
                            Motivo del rifiuto
                        </x-filament::input.label>
                        
                        <x-filament::input.textarea 
                            wire:model="rejectReason"