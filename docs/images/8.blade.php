<?php
use App\Models\User;
use Livewire\Volt\Component;
use Filament\Support\Enums\ActionSize;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public User $user;
    
    public function mount(): void
    {
        $this->user = Auth::user();
    }
    
    public function goHome()
    {
        return redirect()->route('home');
    }
}
?>

<x-filament-panels::page>
    <x-slot name="header">
        <div class="bg-blue-900 text-white p-4 w-full">
            <div class="container mx-auto flex justify-between items-center">
                <a href="#" class="text-3xl font-light">
                    <span class="font-normal">Salute</span> Ora<span class="italic">le</span>
                </a>
            </div>
        </div>
    </x-slot>
    
    <div class="max-w-2xl mx-auto mt-8">
        <!-- Success Message -->
        <div class="mb-12">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Ti ringraziamo per esserti {{ $user->gender === 'F' ? 'iscritta' : 'iscritto' }} al portale</h1>
            <h2 class="text-4xl font-bold text-blue-900">Salute Ora</h2>
        </div>

        <!-- Confirmation Message -->
        <x-filament::section>
            <p class="text-lg text-gray-700 leading-relaxed">
                Procederemo all'esame dei dati e dei documenti inviatici. Qualora il tuo profilo dovesse rientrare nei requisiti richiesti, riceverai una mail di conferma e potrai effettuare l'accesso al servizio.
            </p>
        </x-filament::section>

        <!-- Additional Information (Hidden on mobile, visible on desktop) -->
        <div class="hidden md:block">
            <x-filament::section heading="Prossimi passi" color="primary" class="mt-6">
                <x-filament::list>
                    <x-filament::list.item>
                        Verifica la tua casella email (inclusa la cartella spam)
                    </x-filament::list.item>
                    <x-filament::list.item>
                        La validazione dei dati richiede generalmente 24-48 ore lavorative
                    </x-filament::list.item>
                    <x-filament::list.item>
                        Per assistenza scrivi a <a href="mailto:supporto@saluteora.it" class="text-primary-600 hover:underline">supporto@saluteora.it</a>
                    </x-filament::list.item>
                </x-filament::list>
            </x-filament::section>
        </div>

        <!-- Return Button (Desktop Only) -->
        <div class="hidden md:flex justify-center mt-8">
            <x-filament::button
                wire:click="goHome"
                size="{{ ActionSize::Large }}"
                class="bg-blue-900 hover:bg-blue-800"
            >
                Torna alla home
            </x-filament::button>
        </div>
    </div>
    
    <!-- Mobile Actions (Only visible on mobile) -->
    <div class="fixed bottom-0 left-0 w-full bg-white shadow-lg border-t border-gray-200 p-4 md:hidden z-20">
        <div class="flex justify-between items-center">
            <x-filament::button
                wire:click="goHome"
                size="{{ ActionSize::Large }}"
                class="bg-blue-900 hover:bg-blue-800 w-full"
            >
                Torna alla home
            </x-filament::button>
        </div>
    </div>
    
    <!-- SVG Background Animation -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
        <!-- Floating circles -->
        <svg class="absolute top-1/4 right-1/4 w-64 h-64 opacity-5" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" fill="#0047AB">
                <animate attributeName="cy" values="100;90;100" dur="8s" repeatCount="indefinite" />
                <animate attributeName="r" values="80;85;80" dur="6s" repeatCount="indefinite" />
            </circle>
        </svg>
        
        <!-- Pulsing shape -->
        <svg class="absolute bottom-1/3 left-1/3 w-96 h-96 opacity-5" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path d="M42.9,-76.4C53.3,-68.6,58.1,-52.4,63.5,-38.4C68.9,-24.3,74.8,-12.1,75.6,0.5C76.4,13.1,72.2,26.1,65.6,38.4C59,50.8,50,62.4,38.6,70.5C27.1,78.7,13.6,83.4,-0.4,84C-14.3,84.7,-28.6,81.4,-40.9,73.9C-53.2,66.5,-63.5,55,-68.3,42.2C-73.1,29.3,-72.5,14.7,-72.4,0.1C-72.3,-14.6,-72.7,-29.1,-67.2,-41.6C-61.8,-54.1,-50.4,-64.7,-37.9,-71.1C-25.3,-77.6,-12.7,-79.9,1.2,-82C15,-84,30,-84,42.9,-76.4Z" transform="translate(100 100)" fill="#0047AB">
                <animate attributeName="d" values="M42.9,-76.4C53.3,-68.6,58.1,-52.4,63.5,-38.4C68.9,-24.3,74.8,-12.1,75.6,0.5C76.4,13.1,72.2,26.1,65.6,38.4C59,50.8,50,62.4,38.6,70.5C27.1,78.7,13.6,83.4,-0.4,84C-14.3,84.7,-28.6,81.4,-40.9,73.9C-53.2,66.5,-63.5,55,-68.3,42.2C-73.1,29.3,-72.5,14.7,-72.4,0.1C-72.3,-14.6,-72.7,-29.1,-67.2,-41.6C-61.8,-54.1,-50.4,-64.7,-37.9,-71.1C-25.3,-77.6,-12.7,-79.9,1.2,-82C15,-84,30,-84,42.9,-76.4Z;
                M50.4,-65.1C63.9,-54.2,72.7,-37,79.9,-17.8C87.1,1.5,92.7,22.7,87.6,41.8C82.6,60.9,66.9,77.9,47.8,83.7C28.7,89.6,6.1,84.1,-13.8,76.7C-33.7,69.3,-50.9,59.9,-63.2,45.5C-75.5,31.1,-82.9,11.7,-81.3,-6.5C-79.7,-24.7,-69.1,-41.6,-55.1,-52.5C-41.1,-63.4,-23.7,-68.2,-3.9,-63.9C15.9,-59.6,36.9,-76,50.4,-65.1Z;
                M42.9,-76.4C53.3,-68.6,58.1,-52.4,63.5,-38.4C68.9,-24.3,74.8,-12.1,75.6,0.5C76.4,13.1,72.2,26.1,65.6,38.4C59,50.8,50,62.4,38.6,70.5C27.1,78.7,13.6,83.4,-0.4,84C-14.3,84.7,-28.6,81.4,-40.9,73.9C-53.2,66.5,-63.5,55,-68.3,42.2C-73.1,29.3,-72.5,14.7,-72.4,0.1C-72.3,-14.6,-72.7,-29.1,-67.2,-41.6C-61.8,-54.1,-50.4,-64.7,-37.9,-71.1C-25.3,-77.6,-12.7,-79.9,1.2,-82C15,-84,30,-84,42.9,-76.4Z" 
                dur="12s" repeatCount="indefinite" />
            </path>
        </svg>
        
        <!-- Sliding waves -->
        <svg class="absolute top-2/3 left-0 w-full h-48 opacity-5" viewBox="0 0 1200 200" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,192L60,176C120,160,240,128,360,128C480,128,600,160,720,165.3C840,171,960,149,1080,144C1200,139,1320,149,1380,154.7L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z" fill="#0047AB">
                <animate attributeName="d" values="M0,192L60,176C120,160,240,128,360,128C480,128,600,160,720,165.3C840,171,960,149,1080,144C1200,139,1320,149,1380,154.7L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z;
                M0,128L60,144C120,160,240,192,360,192C480,192,600,160,720,154.7C840,149,960,171,1080,176C1200,181,1320,171,1380,165.3L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z;
                M0,192L60,176C120,160,240,128,360,128C480,128,600,160,720,165.3C840,171,960,149,1080,144C1200,139,1320,149,1380,154.7L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z" 
                dur="12s" repeatCount="indefinite" />
            </path>
        </svg>
    </div>
</x-filament-panels::page>