<x-layouts.app>
    <div>
        @volt('confirmationPage')
            <div>
                <!-- SVG Background Elements (Animati) -->
                <div x-data="{}" class="fixed -z-10 inset-0 overflow-hidden pointer-events-none">
                    @php
                        $svgElements = [
                            [
                                'class' => 'absolute top-20 right-10 opacity-5',
                                'width' => 300,
                                'height' => 300,
                                'viewBox' => '0 0 200 200',
                                'shape' => '<circle cx="100" cy="100" r="80" fill="currentColor" />',
                                'animation' => 'animate-float'
                            ],
                            [
                                'class' => 'absolute bottom-40 left-10 opacity-5',
                                'width' => 250,
                                'height' => 250,
                                'viewBox' => '0 0 200 200',
                                'shape' => '<rect x="20" y="20" width="160" height="160" rx="20" fill="currentColor" />',
                                'animation' => 'animate-pulse-slow'
                            ],
                            [
                                'class' => 'absolute top-1/3 left-1/4 opacity-5',
                                'width' => 200,
                                'height' => 200,
                                'viewBox' => '0 0 200 200',
                                'shape' => '<path d="M100,20 L180,160 L20,160 Z" fill="currentColor" />',
                                'animation' => 'animate-float-delay'
                            ],
                        ];
                    @endphp

                    @foreach ($svgElements as $element)
                        <svg class="text-primary-500 {{ $element['class'] }} {{ $element['animation'] }}" 
                            width="{{ $element['width'] }}" 
                            height="{{ $element['height'] }}" 
                            viewBox="{{ $element['viewBox'] }}">
                            {!! $element['shape'] !!}
                        </svg>
                    @endforeach
                </div>

                <x-filament::section>
                    <div class="max-w-4xl mx-auto">
                        <!-- Checkmark SVG Animation Container -->
                        <div x-data="{ animate: false }" 
                            x-init="setTimeout(() => animate = true, 300)" 
                            class="flex justify-center mb-10">
                            <div class="relative h-24 w-24 text-success-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="h-full w-full">
                                    <circle 
                                        cx="50" cy="50" r="45" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        stroke-width="5" 
                                        stroke-linecap="round"
                                        x-bind:class="animate ? 'opacity-100' : 'opacity-0'"
                                        x-bind:style="animate ? 'stroke-dasharray: 283; stroke-dashoffset: 0; transition: stroke-dashoffset 1s ease, opacity 0.4s ease;' : 'stroke-dasharray: 283; stroke-dashoffset: 283;'">
                                    </circle>
                                    <path 
                                        d="M30 50 L45 65 L70 35" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        stroke-width="5" 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round"
                                        x-bind:class="animate ? 'opacity-100' : 'opacity-0'"
                                        x-bind:style="animate ? 'stroke-dasharray: 60; stroke-dashoffset: 0; transition: stroke-dashoffset 0.5s ease 0.7s, opacity 0.1s ease 0.7s;' : 'stroke-dasharray: 60; stroke-dashoffset: 60;'">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <x-filament::header.heading tag="h1" class="text-3xl mb-6">
                                {{ __('Ti ringraziamo per aver inoltrato la tua richiesta.') }}
                            </x-filament::header.heading>
                            
                            <p class="text-xl mb-12">
                                {{ __('Ti verrà comunicata l\'eventuale accettazione tramite mail nel più breve tempo possibile.') }}
                            </p>
                            
                            <div class="flex justify-center mb-12">
                                <x-filament::button 
                                    tag="a" 
                                    href="{{ route('home') }}" 
                                    color="primary" 
                                    size="lg">
                                    {{ __('Torna alla Home') }}
                                </x-filament::button>
                            </div>
                        </div>

                        <!-- Timeline del processo di prenotazione -->
                        <div class="mt-12 mb-12 max-w-lg mx-auto hidden md:block">
                            <x-filament::section.heading>
                                {{ __('Processo di prenotazione') }}
                            </x-filament::section.heading>
                            
                            @php
                                $steps = [
                                    [
                                        'title' => 'Richiesta inviata',
                                        'description' => 'La tua richiesta è stata inviata con successo.',
                                        'icon' => 'heroicon-o-check-circle',
                                        'status' => 'complete'
                                    ],
                                    [
                                        'title' => 'Conferma via email',
                                        'description' => 'Riceverai un\'email di conferma con tutti i dettagli.',
                                        'icon' => 'heroicon-o-envelope',
                                        'status' => 'upcoming'
                                    ],
                                    [
                                        'title' => 'Visita',
                                        'description' => 'Presentati per la tua visita nella data e ora confermate.',
                                        'icon' => 'heroicon-o-calendar',
                                        'status' => 'upcoming'
                                    ]
                                ];
                            @endphp
                            
                            <ol class="relative border-l border-gray-200 dark:border-gray-700 ml-3">
                                @foreach ($steps as $index => $step)
                                    <li class="mb-10 ml-6">
                                        <span class="absolute flex items-center justify-center w-8 h-8 rounded-full -left-4 
                                            {{ $step['status'] === 'complete' ? 'bg-primary-100 ring-primary-500