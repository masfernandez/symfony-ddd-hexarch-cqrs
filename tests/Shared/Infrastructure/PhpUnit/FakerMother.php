<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit;

use Faker\Factory;
use Faker\Generator;

class FakerMother
{
    private static ?Generator $faker;

    public static function random(): Generator
    {
        return self::$faker = self::$faker ?? Factory::create();
    }
}
