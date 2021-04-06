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

use Simps\Utils\Collection;

class ValidationData implements \ArrayAccess
{
    protected $data;

    protected $fields;

    public function __construct($data = null, $fields = null)
    {
        $this->data = new Collection($data);
        $this->fields = $fields;
    }

    public function has($key)
    {
        $key = str_replace('*', '0', $key);
        return $this->data->has($key);
    }

    public function get($key = null, $default = null)
    {
        $key = str_replace('*', '0', $key);
        return $this->data->get($key, $default);
    }

    public function set($key, $value)
    {
        $key = str_replace('*', '0', $key);
        $this->data->set($key, $value);
    }

    public function filter()
    {
        $result = [];
        foreach ($this->fields as $field) {
            $i = strpos($field, '.');
            if ($i !== false) {
                $field = substr($field, 0, $i);
            }
            if (isset($this->data[$field]) && ! isset($result[$field])) {
                $result[$field] = $this->data[$field];
            }
        }
        return $result;
    }

    public function all()
    {
        $result = [];
        foreach ($this->fields as $field) {
            $i = strpos($field, '.');
            if ($i !== false) {
                $field = substr($field, 0, $i);
            }
            if (! isset($result[$field])) {
                $result[$field] = $this->data[$field] ?? '';
            }
        }
        return $result;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
