<?php

use Illuminate\Support\Facades\Route;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class AcceptedAppointmentsComponent extends Component
{
    public function render()
    {
        $appointments = Appointment::where('status', 'accepted')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('appointments.accepted', [
            'appointments' => $appointments
        ]);
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = 'cancelled';
        $appointment->save();

        Notification::make()
            ->title('Appuntamento cancellato')
            ->warning()
            ->send();

        return redirect()->route('appointments.accepted');
    }
    
    public function createMedicalReport($appointmentId)
    {
        return redirect()->route('reports.create', ['appointment_id' => $appointmentId]);
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
            <h1 class="text-blue-900 text-3xl font-bold mb-8">Appuntamenti accettati</h1>
            
            <div class="space-y-6">
                @forelse($appointments as $appointment)
                    <x-filament::section>
                        <div x-data="{ open: false }" class="relative">
                            <div class="bg-white rounded-t-xl p-4 flex items-center">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-3xl text-green-700 font-bold mr-4">
                                    {{ substr($appointment->patient->name, 0, 1) }}
                                </div>
                                <div class="flex-grow">
                                    <h2 class="text-green-700 text-xl font-bold">{{ $appointment->patient->name }}</h2>
                                    <p class="text-gray-400">
                                        @if($appointment->appointment_date)
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d F') }} - 
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                        @endif
                                    </p>
                                </div>
                                
                                <div>
                                    <x-filament::button
                                        color="danger"
                                        icon="heroicon-o-x-mark"
                                        wire:click="cancelAppointment('{{ $appointment->id }}')"
                                        type="button"
                                        class="rounded-lg"
                                    />
                                </div>
                            </div>
                            
                            <div 
                                wire:click="createMedicalReport('{{ $appointment->id }}')"
                                class="bg-blue-900 text-white py-3 px-4 rounded-b-xl text-center font-semibold cursor-pointer hover:bg-blue-800 transition"
                            >
                                Compila il referto
                            </div>
                        </div>
                    </x-filament::section>
                @empty
                    <x-filament::section>
                        <div class="text-center py-6">
                            <h3 class="text-lg font-medium text-gray-500">Nessun appuntamento accettato</h3>
                            <p class="mt-2 text-sm text-gray-400">Non ci sono appuntamenti accettati al momento.</p>
                        </div>
                    </x-filament::section>
                @endforelse
            </div>
            
            <div class="mt-12 space-y-4">
                <x-filament::button
                    tag="a"
                    href="{{ route('appointments.requests') }}"
                    color="primary"
                    size="xl"
                    class="w-full justify-center rounded-full py-4"
                >
                    RICHIESTE DI PRENOTAZIONE
                </x-filament::button>
                
                <x-filament::button
                    tag="a"
                    href="{{ route('appointments.rejected') }}"
                    color="primary"
                    size="xl"
                    class="w-full justify-center rounded-full py-4"
                >
                    APPUNTAMENTI RIFIUTATI
                </x-filament::button>
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

@folio('appointments.accepted')
<?php

use function Laravel\Folio\{name};
use function Livewire\Volt\{state, mount, rules, computed};

name('appointments.accepted');

state(['appointmentId' => null]);

$initializeModal = function ($appointmentId) {
    $this->appointmentId = $appointmentId;
};

$cancelAppointment = function () {
    if (!$this->appointmentId) {
        return;
    }
    
    $appointment = App\Models\Appointment::find($this->appointmentId);
    
    if ($appointment) {
        $appointment->status = 'cancelled';
        $appointment->save();
        
        Filament\Notifications\Notification::make()
            ->title('Appuntamento cancellato')
            ->warning()
            ->send();
    }
    
    $this->dispatch('appointmentCancelled');
    $this->appointmentId = null;
};

$openReportForm = function ($appointmentId) {
    return redirect()->route('reports.create', ['appointment_id' => $appointmentId]);
};

?>

<div>
    @script
        $wire.on('appointmentCancelled', () => {
            window.location.reload();
        });
    @endscript
</div>
@endfolio