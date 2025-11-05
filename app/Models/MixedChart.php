<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Chart\Database\Factories\MixedChartFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Chart\Models\MixedChart.
 *
 * @property Collection<int, Chart> $charts
 * @property int|null $charts_count
 *
 * @method static MixedChartFactory factory($count = null, $state = [])
 * @method static Builder|MixedChart newModelQuery()
 * @method static Builder|MixedChart newQuery()
 * @method static Builder|MixedChart query()
 *
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 *
 * @mixin IdeHelperMixedChart
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder<static>|MixedChart whereCreatedAt($value)
 * @method static Builder<static>|MixedChart whereCreatedBy($value)
 * @method static Builder<static>|MixedChart whereId($value)
 * @method static Builder<static>|MixedChart whereName($value)
 * @method static Builder<static>|MixedChart whereUpdatedAt($value)
 * @method static Builder<static>|MixedChart whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class MixedChart extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'id',
        'name',
    ];

    // ---- relations

    public function charts(): MorphMany
    {
        /**
         * @phpstan-ignore argument.type
         */
        Relation::morphMap([
            'question_chart' => 'Modules\Quaeris\Models\QuestionChart',
            'mixed_chart' => self::class,
        ]);

        return $this->morphMany(Chart::class, 'post');
    }
}
