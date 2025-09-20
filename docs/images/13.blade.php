<?php

use function Livewire\Volt\{state, rules, computed};
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Enums\ActionSize;
use App\Models\User;
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
            <h1 class="text-2xl font-bold text-[#003b71] mb-8">Compila il seguente modulo per iscriverti</h1>
            
            <div class="max-w-md mx-auto bg-white/50 backdrop-blur-sm rounded-xl p-6 shadow-sm">
                <livewire:volt>
                    @volt
                    state([
                        'name' => '',
                        'certificationFile' => null,
                    ]);
                    
                    rules([
                        'name' => ['required', 'string', 'min:3', 'max:255'],
                        'certificationFile' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
                    ]);
                    
                    $form = null;
                    
                    function submit(): void
                    {
                        $this->validate();
                        
                        // Save registration data via Laraxot
                        $userData = [
                            'name' => $this->name,
                            'certification_path' => $this->certificationFile ? 
                                Xot::saveFile($this->certificationFile, 'certifications') : null,
                        ];
                        
                        // Process registration
                        try {
                            // Additional processing with Laraxot if needed
                            Xot::processRegistration($userData);
                            
                            // Redirect to next step or dashboard
                            $this->redirect(route('registration.step2'));
                            
                        } catch (\Exception $e) {
                            $this->addError('form', 'Si è verificato un errore durante la registrazione. Riprova più tardi.');
                        }
                    }
                    @endvolt
                    
                    <x-filament-forms::form wire:submit="submit">
                        {{ $this->form }}
                        
                        <x-filament::section>
                            {{ 
                                FilamentForms\Components\TextInput::make('name')
                                    ->label('')
                                    ->placeholder('Nome e Cognome')
                                    ->required()
                                    ->maxLength(255)
                                    ->extraAttributes(['class' => 'rounded-full'])
                                    ->autocomplete('name')
                            }}
                            
                            {{ 
                                FilamentForms\Components\FileUpload::make('certificationFile')
                                    ->label('Carica certificazione iscrizione Ordine')
                                    ->disk('public')
                                    ->directory('certifications')
                                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                    ->maxSize(10240)
                                    ->buttonLabel('Carica certificazione iscrizione Ordine')
                                    ->extraAttributes(['class' => 'rounded-full'])
                            }}
                            
                            <div class="mt-6">
                                {{ 
                                    \Filament\Actions\Action::make('submit')
                                        ->label('CONTINUA')
                                        ->submit('submit')
                                        ->color('primary')
                                        ->size('xl')
                                        ->extraAttributes(['class' => 'w-full rounded-full bg-[#003b71] pulse-button']) 
                                }}
                            </div>
                        </x-filament::section>
                    </x-filament-forms::form>
                </livewire:volt>
            </div>
        </div>
    </div>
    
    @push('styles')
    <style>
        @keyframes wave {
            0% { d: path('M0,100 C150,120 300,80 500,100 L500,0 L0,0 Z'); }
            100% { d: path('M0,100 C200,80 300,120 500,100 L500,0 L0,0 Z'); }
        }
        
        .pulse-button {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }
    </style>
    @endpush
</x-filament-panels::page>