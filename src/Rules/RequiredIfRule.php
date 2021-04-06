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
 * 用法 required_if:field,[value]
 */
class RequiredIfRule extends Rule
{
    protected $required = true;

    protected $command = 'required_if';

    protected $message = ':attribute required if {0}';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        if (isset($options[1])) {
            if ($validateData->get($options[0], null) == $options[1]) {
                return $validateData->has($field);
            }
        } elseif (isset($options[0])) {
            if ($validateData->has($options[0])) {
                return $validateData->has($field);
            }
        }
        return true;
    }
}
