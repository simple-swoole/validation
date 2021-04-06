<?php

declare(strict_types=1);
/**
 * This file is part of Simps.
 *
 * @link     https://simps.io
 * @document https://doc.simps.io
 * @license  https://github.com/simple-swoole/simps/blob/master/LICENSE
 */
namespace Simps\Validation\Rules;

use Simps\Validation\Rule;
use Simps\Validation\ValidationData;

class EmptyRule extends Rule
{
    protected $command = 'empty';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        return true;
    }
}
