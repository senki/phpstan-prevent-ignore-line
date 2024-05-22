<?php

namespace Senki\PhpstanPreventIgnoreLine\Tests;

class ClassFile
{
    // @phpstan-ignore-next-line
    public $name = 'Senki';

    public $date = 'Senki'; // @phpstan-ignore-line

    // @phpstan-ignore-next-line
    public const NAME = gmdate(123);

    public function simple(): array { return []; } // @phpstan-ignore-line

    public function withArgument(
        // @phpstan-ignore-next-line
        \NonExistentClass $name
    ): string {
        return 123; // @phpstan-ignore-line
    }
}
