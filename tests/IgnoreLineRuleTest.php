<?php

declare(strict_types=1);

namespace App;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Senki\PhpstanPreventIgnoreLine\IgnoreLineRule;

/**
 * @extends RuleTestCase<IgnoreLineRule>
 */
class IgnoreLineRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new IgnoreLineRule();
    }

    public function testRule(): void
    {
        $this->analyse(
            [ __DIR__ . '/data/ClassFile.php'],
            [
                ['Use of @phpstan-ignore-next-line comment is not allowed.', 7],
                ['Use of @phpstan-ignore-line comment is not allowed.', 10],
                ['Use of @phpstan-ignore-next-line comment is not allowed.', 12],
                ['Use of @phpstan-ignore-line comment is not allowed.', 15],
                ['Use of @phpstan-ignore-next-line comment is not allowed.', 18],
                ['Use of @phpstan-ignore-line comment is not allowed.', 21],
                // No other rule loaded during unit test, so no error reported to ignore.
                ['No error to ignore is reported on line 8.', 8],
                ['No error to ignore is reported on line 10.', 10],
                ['No error to ignore is reported on line 13.', 13],
                ['No error to ignore is reported on line 15.', 15],
                ['No error to ignore is reported on line 19.', 19],
                ['No error to ignore is reported on line 21.', 21],
            ]
        );

    }
}
