<?php

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

/**
 * Modules\Chart\Models\Chart.
 *
 * @property int|null $height
 * @property string|null $type
 * @property int|null $width
 * @method static \Modules\Chart\Database\Factories\ChartFactory factory($count = null, $state = [])
 * @method static Builder|Chart newModelQuery()
 * @method static Builder|Chart newQuery()
 * @method static Builder|Chart query()
 * @property-read \Modules\Blog\Models\Profile|null $creator
 * @property-read \Modules\Blog\Models\Profile|null $updater
 * @mixin \Eloquent
 */
class Chart extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'id',
        'post_id',
        'post_type',
        'type',
        'width', 'height',
        'color',
        'bg_color',
        'font_family',
        'font_size',
        'font_style',
        'y_grace',
        'yaxis_hide',
        'list_color',
        'grace',
        'x_label_angle',
        'show_box',
        'x_label_margin',
        'plot_perc_width',
        'plot_value_show',
        'plot_value_format',
        'plot_value_pos',
        'plot_value_color',
        'group_by',
        'sort_by',
        'transparency',
        'colors',
    ];

    /**
     * Undocumented variable.
     *
     * @var array
     */
    protected $attributes = [
        'list_color' => '#d60021',
        'color' => '#d60021',
        'font_family' => 15,
        'font_style' => 9002,
        'font_size' => 12,
        'x_label_angle' => 0,
        'show_box' => false,
        'x_label_margin' => 10,
        'plot_perc_width' => 90,
        'plot_value_show' => 1,
        'plot_value_pos' => 1,
        'plot_value_color' => '#000000',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'colors' => 'array',
    ];

    // /**
    //  * @return int|string|null
    //  */
    // public function getParentStyle(string $name)
    // {
    //     $panel = PanelService::make()->getRequestPanel();

    //     if (null === $panel) {
    //         return $this->attributes[$name] ?? null;
    //     }
    //     $parent = $panel->getParent();

    //     if (null === $parent) {
    //         return $this->attributes[$name] ?? null;
    //     }
    //     $parent = $parent->getRow();
    //     if (! method_exists($parent, 'chart')) {
    //         return $this->attributes[$name] ?? null;
    //     }
    //     // dddx([$name, $panel->row, $parent->{$name}]);
    //     // $value = $parent->chart->{$name};

    //     $value = $parent->chart->attributes[$name] ?? null;

    //     $this->{$name} = $value;
    //     $this->save();
    //     if (! \is_string($value) && ! \is_int($value)) {
    //         return null;
    //     }

    //     return $value;
    // }

    public function getPanelRow(string $parent_field, string $my_field): int|string|null
    {
        // $panel = PanelService::make()->getRequestPanel();
        // if (! \is_object($panel)) {
        //     return null;
        // }
        // $panel_row = $panel->row;
        $panel_row = $this;

        try {
            $value = $panel_row->{$parent_field};
            $this->{$my_field} = $value;
            $this->save();
        } catch (\ErrorException $errorException) {
            $msg = [
                'message' => $errorException->getMessage(),
                'line' => $errorException->getLine(),
                'file' => $errorException->getFile(),
                'panel_row_class' => $panel_row::class,
            ];
            // echo '<pre>'.print_r($msg,true).'</pre>';
            $value = null;
        }

        return $value;
    }

    // ---------- Getter
    // public function getColorAttribute(?string $value): ?string
    // {
    //     if (null !== $value) {
    //         // return $value;
    //     }

    //     return (string) $this->getParentStyle('color');
    // }

    // public function getListColorAttribute(?string $value): ?string
    // {
    //     if (null !== $value) {
    //         return $value;
    //     }

    //     return (string) $this->getParentStyle('list_color');
    // }

    //     public function getXLabelAngleAttribute(?string $value): ?string
    //     {
    //         if (null !== $value) {
    //             return $value;
    //         }
    //         /*
    //         $this->x_label_angle = 0;
    //         $this->save();
    //         $value = $this->x_label_angle;

    //         return $value;
    // */
    //         return (string) $this->getParentStyle('x_label_angle');
    //     }

    // public function getFontFamilyAttribute(?int $value): int
    // {
    //     if (null !== $value && 0 !== $value) {
    //         return (int) $value;
    //     }

    //     return (int) $this->getParentStyle('font_family');
    // }

    // public function getFontStyleAttribute(?int $value): int
    // {
    //     if (null !== $value && 0 !== $value) {
    //         return (int) $value;
    //     }

    //     return (int) $this->getParentStyle('font_style');
    // }

    // public function getFontSizeAttribute(?int $value): int
    // {
    //     if (null !== $value && 0 !== $value) {
    //         return (int) $value;
    //     }

    //     return (int) $this->getParentStyle('font_size');
    // }

    public function getTypeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        return $this->attributes['type'] ?? (string) $this->getPanelRow('chart_type', 'type');
    }

    public function getWidthAttribute(?string $value): ?int
    {
        if ($value === null) {
            return (int) $this->getPanelRow('width', 'width');
        }

        if ((int) $value === 0) {
            return (int) $this->getPanelRow('width', 'width');
        }

        return (int) $value;
    }

    public function getHeightAttribute(?string $value): ?int
    {
        if ($value === null) {
            return (int) $this->getPanelRow('height', 'height');
        }
        if ((int) $value === 0) {
            return (int) $this->getPanelRow('height', 'height');
        }

        return (int) $value;
    }

    public function getSettings(): array
    {
        Assert::notNull($this->type, '['.__FILE__.']['.__LINE__.']');
        if (Str::startsWith($this->type, 'mixed')) {
            $parz = \array_slice(explode(':', $this->type), 1);
            $mixed_id = implode('|', $parz);
            $mixed = MixedChart::firstWhere(['id' => $mixed_id]);
            Assert::notNull($mixed, '['.__FILE__.']['.__LINE__.']');
            Assert::isInstanceof($mixed->charts, Collection::class);

            return $mixed->charts->toArray();
        }

        return [$this->toArray()];
    }
}
