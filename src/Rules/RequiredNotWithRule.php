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
 * 当指定字段存在的时候, 当前字段可以不存在
 * 用法 required_not_with:field1,field2, ...
 */
class RequiredNotWithRule extends Rule
{
    protected $required = true;

    protected $command = 'required_not_with';

    protected $message = ':attribute required not with {0}';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        if ($this->hasFields($validateData, $options)) {
            return true;
        }
        return $validateData->has($field);
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
