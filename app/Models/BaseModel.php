<?php

declare(strict_types=1);

namespace Modules\Chart\Models;

use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 */
abstract class BaseModel extends XotBaseModel
{
    /** @var string */
    protected $connection = null; // Use default connection instead of xot to access question_charts table

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            ...parent::casts(),
        ];
    }
}
