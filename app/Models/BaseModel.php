<?php

declare(strict_types=1);

namespace Modules\Chart\Models;

use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 *
 * Base model per tutti i modelli del modulo Chart.
 * Estende XotBaseModel e configura la connection 'chart'.
 *
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 */
abstract class BaseModel extends XotBaseModel
{
    // use Searchable;
    // use Cachable;

    /** @var string */
    protected $connection = 'chart';
}
