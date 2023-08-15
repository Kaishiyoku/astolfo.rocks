<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Unknown()
 * @method static static Safe()
 * @method static static Questionable()
 * @method static static Explicit()
 */
final class ImageRating extends Enum
{
    const Unknown = 'unknown';

    const Safe = 'safe';

    const Questionable = 'questionable';

    const Explicit = 'explicit';
}
