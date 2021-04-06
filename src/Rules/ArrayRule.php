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
 * 当前字段必须是数组, 可选类型数组
 * 用法 array:[number,bool,array]
 */
class ArrayRule extends Rule
{
    protected $command = 'array';

    protected $message = ':attribute must is array';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        $type = $options[0] ?? false;
        if (in_array($type, ['number', 'bool', 'array'])) {
            $obj = $validateData->get($field);
            if (is_array($obj)) {
                foreach ($obj as $k => $v) {
                    if ($type == 'number') {
                        if (! is_numeric($v)) {
                            return false;
                        }
                    } elseif ($type == 'bool') {
                        if (! is_bool($v)) {
                            return false;
                        }
                    } elseif ($type == 'array') {
                        if (! is_array($v)) {
                            return false;
                        }
                    }
                }
            }
            return false;
        }
        $obj = $validateData->get($field);
        return is_array($obj);
    }
}
