
@php
    use Filament\Widgets\StatsOverviewWidget;
    use Filament\Widgets\StatsOverviewWidget\Stat;
    use Livewire\Volt\Component;

    new class extends Component {
        public function stats(): array
        {
            return [
                Stat::make('ACCETTATE', '1.842')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->description('01/10/2024 - 05/11/2024')
                    ->chart([7, 15, 12, 25, 10]),

                Stat::make('RIFIUTATE', '326')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->description('01/10/2024 - 05/11/2024')
                    ->chart([2, 5, 3, 8, 4])
            ];
        }
    };
@endphp

<x-filament::page>
    <x-filament::card>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($this->stats() as $stat)
                <x-filament::stats-overview.stat
                    :label="$stat->label"
                    :value="$stat->value"
                    :color="$stat->color"
                    :icon="$stat->icon"
                    :chart="$stat->chart"
                    :description="$stat->description"
                />
            @endforeach
        </div>
    </x-filament::card>
</x-filament::page>