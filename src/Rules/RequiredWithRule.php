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
 * 当指定字段存在的时候, 当前字段必须存在
 * 用法 required_with:field1,field2, ...
 */
class RequiredWithRule extends Rule
{
    protected $required = true;

    protected $command = 'required_with';

    protected $message = ':attribute required with {0}';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        if ($this->hasFields($validateData, $options)) {
            return $validateData->has($field);
        }
        return true;
    }

    protected function hasFields(ValidationData $validateData, $options)
    {
        foreach ($options as $key) {
            if ($validateData->has($key)) {
                return true;
            }
        }
        return false;
    }
}
