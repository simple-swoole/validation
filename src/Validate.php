<?php

declare(strict_types=1);
/**
 * This file is part of Simps.
 *
 * @link     https://simps.io
 * @document https://doc.simps.io
 * @license  https://github.com/simple-swoole/simps/blob/master/LICENSE
 */
namespace Simps\Validation;

class Validate
{
    protected $rules = [
        //        "array.*.field1" => "required",
        //        "array.*.field2" => "required|min:10",
        //        "object.field1" => "required",
        //        "object.field2" => "required|min:10",
        //        "field1" => "required|gt:1",
        //        "field2" => "gt:field1,object.field2",
        //        "field3" => "lt:field1,array.*.field2",
        //        "field4" => "required_with:id,id2",
        //        "field5" => ["required", ["gt" => [1]]],
    ];

    protected $messages = [
        //        "field1" => "字段必须存在",
        //        "field1.required" => "字段必须存在",
    ];

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
