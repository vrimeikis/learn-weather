<?php

declare(strict_types = 1);

namespace App;

use App\Events\ParameterSavedEvent;
use App\Events\ParameterSavingEvent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Parameter
 * @property string $key
 * @property string|null $value
 * @package App
 */
class Parameter extends Model
{
    const PARAMETER_WIND_SPEED = 'wind_speed';
    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];

    protected $dispatchesEvents = [
        'saving' => ParameterSavingEvent::class,
        'saved' => ParameterSavedEvent::class,
    ];
}
