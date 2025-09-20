<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\ChartResource\Pages;

use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Modules\UI\Enums\TableLayoutEnum;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Enums\ActionsPosition;
use Modules\Xot\Filament\Traits\TransTrait;
use Filament\Tables\Actions\DeleteBulkAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Chart\Filament\Resources\ChartResource;

class ListCharts extends XotBaseListRecords
{

    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;

    protected static string $resource = ChartResource::class;


    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id'),
            TextColumn::make('type'),
            TextColumn::make('group_by'),
            TextColumn::make('sort_by'),
            TextColumn::make('width'),
            TextColumn::make('height'),
            TextColumn::make('font_family'),
            TextColumn::make('font_style'),
            TextColumn::make('font_size'),
        ];
    }


}
