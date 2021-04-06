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
 * 当前字段必须是整数
 * 用法 integer
 */
class IntegerRule extends Rule
{
    protected $command = 'integer';

    protected $message = ':attribute must is integer';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        $val = $validateData->get($field);
        return is_numeric($val) && strpos($val, '.') === false;
    }
}
