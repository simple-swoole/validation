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
 * 当前字段必须存在
 * 用法 required
 */
class RequiredRule extends Rule
{
    protected $required = true;

    protected $command = 'required';

    protected $message = ':attribute required';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        return $validateData->has($field);
    }
}
