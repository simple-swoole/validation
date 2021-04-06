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

class NumberRule extends Rule
{
    protected $command = 'number';

    protected $message = ':attribute must is number';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        $val = $validateData->get($field);
        return is_numeric($val);
    }
}
