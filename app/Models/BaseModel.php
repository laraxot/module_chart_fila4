<?php

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Actions\Factory\GetFactoryAction;
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
    // use Searchable;
    // use Cachable;

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @see  https://laravel-news.com/6-eloquent-secrets
     */

    /** @var bool */
    public static $snakeAttributes = true;

    /** @var bool */
    public $incrementing = true;

    /** @var bool */
    public $timestamps = true;

    /** @var int */
    protected $perPage = 30;

    /** @var string */
    protected $connection = 'chart';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['published_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    }

    /** @var string */
    protected $primaryKey = 'id';

    /** @var list<string> */
    protected $hidden = [
        // 'password'
    ];

   
}
