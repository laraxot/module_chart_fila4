<x-layouts.app>
    <div>
        @volt('appointmentBooking')
            <div>
                <x-filament::section>
                    <x-slot name="heading">
                        {{ __('Prenota la tua visita') }}
                    </x-slot>
                    
                    <div class="space-y-8">
                        <!-- Calendario -->
                        <div>
                            @php
                                $currentDate = \Carbon\Carbon::create(2024, 11, 1);
                                $selectedDate = \Carbon\Carbon::create(2024, 11, 12);
                                $availableDates = [7, 12, 13, 18, 20, 26, 28];
                                $daysInMonth = $currentDate->daysInMonth;
                                $firstDayOfMonth = $currentDate->copy()->startOfMonth()->dayOfWeek;
                                $firstDayOfMonth = $firstDayOfMonth === 0 ? 7 : $firstDayOfMonth; // Adjust Sunday to be 7 instead of 0
                                
                                $calendarStart = $currentDate->copy()->startOfMonth()->subDays($firstDayOfMonth - 1);
                                $calendarEnd = $currentDate->copy()->endOfMonth();
                                $calendarDays = [];
                                
                                $dayCounter = $calendarStart->copy();
                                
                                while ($dayCounter <= $calendarEnd) {
                                    $calendarDays[] = [
                                        'date' => $dayCounter->copy(),
                                        'day' => $dayCounter->day,
                                        'isCurrentMonth' => $dayCounter->month === $currentDate->month,
                                        'isSelected' => $dayCounter->isSameDay($selectedDate),
                                        'isAvailable' => in_array($dayCounter->day, $availableDates) && $dayCounter->month === $currentDate->month,
                                    ];
                                    $dayCounter->addDay();
                                }
                                
                                $weekDays = ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'];
                            @endphp
                            
                            <x-filament::card>
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-2xl font-bold text-primary-600">{{ $currentDate->format('F Y') }}</h2>
                                    <div class="flex space-x-2">
                                        <x-filament::button 
                                            wire:click="previousMonth"
                                            icon="heroicon-o-chevron-left"
                                            color="primary"
                                            size="sm" />
                                        <x-filament::button 
                                            wire:click="nextMonth"
                                            icon="heroicon-o-chevron-right"
                                            color="primary"
                                            size="sm" />
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-7 gap-2 mb-2">
                                    @foreach ($weekDays as $day)
                                        <div class="text-center font-medium text-primary-600">{{ $day }}</div>
                                    @endforeach
                                </div>
                                
                                <div class="grid grid-cols-7 gap-2">
                                    @foreach ($calendarDays as $day)
                                        @php
                                            $classes = 'p-2 text-center rounded-md cursor-pointer transition-colors';
                                            if (!$day['isCurrentMonth']) {
                                                $classes .= ' text-gray-300';
                                            } elseif ($day['isSelected']) {
                                                $classes .= ' bg-primary-600 text-white';
                                            } elseif ($day['isAvailable']) {
                                                $classes .= ' bg-primary-100 hover:bg-primary-200';
                                            } else {
                                                $classes .= ' hover:bg-gray-100';
                                            }
                                        @endphp
                                        
                                        <div 
                                            wire:click="selectDate('{{ $day['date']->format('Y-m-d') }}')"
                                            class="{{ $classes }}">
                                            {{ $day['day'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </x-filament::card>
                        </div>
                        
                        <!-- Disponibilità -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-2xl font-bold text-primary-600">{{ __('Disponibilità') }}</h2>
                                <span class="text-gray-500">{{ $selectedDate->format('d F') }}</span>
                            </div>
                            
                            <x-filament::card>
                                <div class="space-y-4">
                                    @php
                                        $timeSlots = [
                                            ['start' => '15:00', 'end' => '16:00'],
                                            ['start' => '16:00', 'end' => '17:00'],
                                            ['start' => '17:00', 'end' => '18:00'],
                                        ];
                                    @endphp
                                    
                                    @foreach ($timeSlots as $slot)
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center text-lg">
                                                <span class="font-medium">{{ $slot['start'] }}</span>
                                                <span class="mx-4 text-gray-400">—</span>
                                                <span class="font-medium">{{ $slot['end'] }}</span>
                                            </div>
                                            <x-filament::button 
                                                wire:click="bookAppointment('{{ $selectedDate->format('Y-m-d') }}', '{{ $slot['start'] }}')"
                                                color="primary">
                                                {{ __('Prenota') }}
                                            </x-filament::button>
                                        </div>
                                    @endforeach
                                </div>
                            </x-filament::card>
                        </div>
                        
                        <!-- Form di prenotazione (mostrato quando si seleziona un orario) -->
                        @if ($showBookingForm)
                            <x-filament::modal width="md" wire:model="showBookingForm">
                                <x-slot name="heading">
                                    {{ __('Conferma prenotazione') }}
                                </x-slot>
                                
                                <x-slot name="description">
                                    {{ __('Compila i dettagli per confermare la tua prenotazione per il giorno') }} 
                                    {{ $selectedDate->format('d/m/Y') }} {{ __('alle ore') }} {{ $selectedTime }}.
                                </x-slot>
                                
                                <x-filament-forms::form wire:submit="confirmBooking">
                                    <div class="space-y-4">
                                        <x-filament-forms::field-wrapper
                                            id="name"
                                            statePath="name"
                                            label="{{ __('Nome e cognome') }}"
                                            required>
                                            <x-filament::input.text wire:model="name" />
                                        </x-filament-forms::field-wrapper>
                                        
                                        <x-filament-forms::field-wrapper
                                            id="email"
                                            statePath="email"
                                            label="{{ __('Email') }}"
                                            required>
                                            <x-filament::input.text type="email" wire:model="email" />
                                        </x-filament-forms::field-wrapper>
                                        
                                        <x-filament-forms::field-wrapper
                                            id="phone"
                                            statePath="phone"
                                            label="{{ __('Telefono') }}"
                                            required>
                                            <x-filament::input.text wire:model="phone" />
                                        </x-filament-forms::field-wrapper>
                                        
                                        <x-filament-forms::field-wrapper
                                            id="notes"
                                            statePath="notes"
                                            label="{{ __('Note (opzionale)') }}">
                                            <x-filament::input.textarea wire:model="notes" rows="3" />
                                        </x-filament-forms::field-wrapper>
                                        
                                        <x-filament-forms::field-wrapper
                                            id="treatmentType"
                                            statePath="treatmentType"
                                            label="{{ __('Tipo di visita') }}"
                                            required>
                                            <x-filament::select
                                                wire:model="treatmentType"
                                                :options="[
                                                    'check-up' => 'Check-up generale',
                                                    'cleaning' => 'Pulizia dentale',
                                                    'emergency' => 'Emergenza',
                                                    'consultation' => 'Consulenza',
                                                ]"
                                            />
                                        </x-filament-forms::field-wrapper>
                                        
                                        <x-filament-forms::field-wrapper
                                            id="consent"
                                            statePath="consent"
                                            label="{{ __('Privacy') }}"
                                            required>
                                            <x-filament::input.checkbox wire:model="consent" /> 
                                            <span class="ml-2 text-sm text-gray-600">
                                                {{ __('Acconsento al trattamento dei dati personali') }}
                                            </span>
                                        </x-filament-forms::field-wrapper>
                                    </div>
                                    
                                    <x-slot name="footer">
                                        <div class="flex justify-end gap-x-4">
                                            <x-filament::button
                                                wire:click="$set('showBookingForm', false)"
                                                color="gray">
                                                {{ __('Annulla') }}
                                            </x-filament::button>
                                            
                                            <x-filament::button
                                                type="submit"
                                                color="primary">
                                                {{ __('Conferma prenotazione') }}
                                            </x-filament::button>
                                        </div>
                                    </x-slot>
                                </x-filament-forms::form>
                            </x-filament::modal>
                        @endif
                    </div>
                </x-filament::section>
            </div>
            
            <script>
                export default {
                    data() {
                        return {
                            selectedDate: @entangle('selectedDate'),
                            selectedTime: @entangle('selectedTime'),
                            showBookingForm: @entangle('showBookingForm'),
                            name: @entangle('name'),
                            email: @entangle('email'),
                            phone: @entangle('phone'),
                            notes: @entangle('notes'),
                            treatmentType: @entangle('treatmentType'),
                            consent: @entangle('consent'),
                        };
                    },
                    
                    methods: {
                        previousMonth() {
                            this.$wire.previousMonth();
                        },
                        
                        nextMonth() {
                            this.$wire.nextMonth();
                        },
                        
                        selectDate(date) {
                            this.$wire.selectDate(date);
                        },
                        
                        bookAppointment(date, time) {
                            this.$wire.bookAppointment(date, time);
                        },
                        
                        confirmBooking() {
                            this.$wire.confirmBooking();
                        }
                    }
                }
            </script>
        @endvolt
    </div>
    
    @push('scripts')
        <!-- SVG Animazioni per lo sfondo -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const createSvgElement = (tag, attrs = {}) => {
                    const el = document.createElementNS('http://www.w3.org/2000/svg', tag);
                    for (const [key