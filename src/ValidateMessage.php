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

class ValidateMessage
{
    protected $errors;

    protected $messages;

    public function __construct($messages, $errors)
    {
        $this->messages = $messages;
        $this->errors = $errors;
    }

    /**
     * @param null $field
     * @return string
     */
    public function first($field = null)
    {
        if ($field === null) {
            foreach ($this->errors as $v) {
                return $this->packMessage($v[0], $v[1], $v[2], $v[3]);
            }
        } else {
            foreach ($this->errors as $v) {
                if ($v[0] == $field) {
                    return $this->packMessage($v[0], $v[1], $v[2], $v[3]);
                }
            }
        }
        return null;
    }

    /**
     * @return array
     */
    public function get()
    {
        $errors = [];
        foreach ($this->errors as $v) {
            if (! isset($errors[$v[0]])) {
                $errors[$v[0]] = [];
            }
            $errors[$v[0]][] = $this->packMessage($v[0], $v[1], $v[2], $v[3]);
        }
        return $errors;
    }

    protected function packMessage($field, $command, $options, $message)
    {
        if (isset($this->messages["{$field}.{$command}"])) {
            $str = $this->messages["{$field}.{$command}"];
        } elseif (isset($this->messages[$field])) {
            $str = $this->messages[$field];
        } else {
            $str = str_replace(':attribute', $field, $message);
        }

        foreach ($options as $k => $v) {
            $str = str_replace("{{$k}}", $v, $str);
        }
        return $str;
    }
}
