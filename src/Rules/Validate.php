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
use Simps\Validation\Validator;

/*
 * 当指定字段使用子验证器进行验证
 * 用法 validate:App\ObjValidate,object,false
 */
class Validate extends Rule
{
    protected $command = 'validate';

    protected $message = ':attribute format error.';

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        if (isset($options[0])) {
            $data = $validateData->get($field);
            if (is_array($data)) {
                $cls = $options[0];
                $type = $options[1] ?? 'object';
                $filter = $options[2] ?? 'true';
                $filter = $filter == 'true';
                if ($type == 'object') {
                    $r = container(Validator::class)->check($cls, $data);
                    if ($r instanceof ValidationData) {
                        if ($filter) {
                            $validateData->set($field, $r->filter());
                        }
                        return true;
                    }
                } elseif ($type == 'array') {
                    foreach ($data as $k => $item) {
                        $r = container(Validator::class)->check($cls, $item);
                        if ($r instanceof ValidationData) {
                            if ($filter) {
                                $validateData->set("{$field}.{$k}", $r->filter());
                            }
                        } else {
                            return false;
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }
}
