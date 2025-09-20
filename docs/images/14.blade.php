<?php

use function Livewire\Volt\{state, computed};
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Laraxot\Core\Facades\XotFacade as Xot;

?>

<x-filament-panels::page>
    <div class="relative overflow-hidden">
        <!-- SVG Wave Background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <svg viewBox="0 0 500 150" preserveAspectRatio="none" class="absolute top-0 w-full h-52">
                <path 
                    d="M0,100 C150,120 300,80 500,100 L500,0 L0,0 Z" 
                    fill="#003b71" 
                    class="animate-[wave_8s_ease-in-out_infinite_alternate]">
                </path>
            </svg>
        </div>

        <div class="container px-4 mx-auto relative z-10">
            <livewire:volt>
                @volt
                state([
                    'user' => null,
                    'registrationTime' => null,
                ]);
                
                public function mount()
                {
                    $this->user = Auth::user() ?? session('temp_user_data');
                    $this->registrationTime = now();
                    
                    // Send notification for internal tracking
                    Notification::make()
                        ->title('Nuova registrazione')
                        ->body('Un nuovo utente si è registrato al portale.')
                        ->actions([
                            \Filament\Notifications\Actions\Action::make('review')
                                ->label('Rivedi')
                                ->url(route('filament.admin.resources.users.view', ['record' => $this->user?->id ?? 'latest']))
                                ->button(),
                        ])
                        ->sendToDatabase(User::whereHas('roles', function ($query) {
                            $query->where('name', 'admin');
                        })->get());
                }
                
                public function getEstimatedReviewTimeString()
                {
                    // Calculate based on current workload, business hours, etc.
                    return '1-2 giorni lavorativi';
                }
                
                public function getTrackingIdProperty()
                {
                    // Generate unique tracking ID for this registration
                    return strtoupper(substr(md5($this->user?->email . $this->registrationTime), 0, 8));
                }
                @endvolt
                
                <div class="max-w-lg mx-auto mt-8 animate-[fadeIn_1.5s_ease-in-out]">
                    <!-- Success Icon (Hidden on mobile) -->
                    <div class="hidden md:flex justify-center mb-8">
                        <div class="bg-green-100 p-4 rounded-full animate-[scaleCheck_1s_ease-in-out]">
                            <x-heroicon-o-check-circle class="h-16 w-16 text-green-600" />
                        </div>
                    </div>
                    
                    <!-- Confirmation Message -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-normal text-gray-800">
                            Ti ringraziamo per esserti iscritt{{ $this->user?->gender === 'F' ? 'a' : 'o' }} al portale<br>
                            <span class="font-bold text-black text-3xl">Salute Ora</span>
                        </h2>
                    </div>
                    
                    <!-- Information Text -->
                    <div class="text-lg text-gray-700 leading-relaxed">
                        <p>
                            Procederemo all'esame dei dati e dei documenti inviatici. Qualora il tuo profilo dovesse rientrare nei requisiti richiesti, riceverai una mail di conferma e potrai effettuare l'accesso al servizio.
                        </p>
                    </div>
                    
                    <!-- Additional Information Card -->
                    <div class="hidden md:block mt-10">
                        <x-filament::section>
                            <x-slot name="heading">
                                Informazioni sulla tua richiesta
                            </x-slot>
                            
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">ID Richiesta</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $this->trackingId }}</dd>
                                </div>
                                
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Data registrazione</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $this->registrationTime->format('d/m/Y H:i') }}</dd>
                                </div>
                                
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Tempo stimato di revisione</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $this->getEstimatedReviewTimeString() }}</dd>
                                </div>
                            </dl>
                            
                            <x-slot name="footer">
                                <div class="flex justify-between items-center">
                                    {{ 
                                        \Filament\Actions\Action::make('home')
                                            ->label('Torna alla home')
                                            ->url(route('home'))
                                            ->outlined() 
                                    }}
                                    
                                    {{ 
                                        \Filament\Actions\Action::make('contact')
                                            ->label('Contattaci')
                                            ->url(route('contact'))
                                            ->icon('heroicon-o-envelope') 
                                    }}
                                </div>
                            </x-slot>
                        </x-filament::section>
                    </div>
                    
                    <!-- Mobile-only action button -->
                    <div class="mt-8 md:hidden">
                        {{ 
                            \Filament\Actions\Action::make('home')
                                ->label('Torna alla home')
                                ->url(route('home'))
                                ->button()
                                ->extraAttributes(['class' => 'w-full']) 
                        }}
                    </div>
                </div>
            </livewire:volt>
        </div>
    </div>
    
    @push('styles')
    <style>
        @keyframes wave {
            0% { d: path('M0,100 C150,120 300,80 500,100 L500,0 L0,0 Z'); }
            100% { d: path('M0,100 C200,80 300,120 500,100 L500,0 L0,0 Z'); }
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes scaleCheck {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
    @endpush
</x-filament-panels::page>