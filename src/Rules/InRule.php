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

/*
 * 当前字段必须是在 ... 之中
 * 用法 in:0,1,2
 */
class InRule extends Rule
{
    protected $command = 'in';

    protected $message = ':attribute must in {0}, ...';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        return in_array($validateData->get($field), $options);
    }
}
