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

class Validator
{
    /** @var array */
    protected $config;

    /** @var Rule[] */
    protected $commands = [];

    /** @var Validate[] */
    protected $validates = [];

    public function __construct()
    {
        // 读取配置
        $this->config = config('validator', []);
        // 读取规则
        foreach ($this->config['register'] as $cls) {
            $obj = new $cls();
            $this->commands[$obj->getCommand()] = $obj;
        }
    }

    public function checkMany($str, $data = null)
    {
        return $this->check($str, $data, true);
    }

    /*
     * 用法
     * @method validate(IdArray::class, $data = null, $many = false)
     * @method validate()->check(IdArray::class, $data = null, $many = false)
     */

    /**
     * @param string $str
     * @param null $data
     * @param bool $many
     * @return ValidateMessage|ValidationData
     */
    public function check($str, $data = null, $many = false)
    {
        $valid = $this->getValidate($str);
        $rules = $valid->getRules();
        $data = new ValidationData($data, array_keys($rules));
        $errors = [];
        // 循环遍历字段
        foreach ($rules as $field => $rule) {
            // 是否要求字段必须存在
            $hasField = $data->has($field);

            // 循环遍历规则
            foreach ($rule as $item) {
                foreach ($item as $command => $options) {
                    // 如果规则存在
                    if (isset($this->commands[$command])) {
                        $rObj = $this->commands[$command];
                        // 是否必须验证（规则要求验证必须验证，否则看字段是否存在）
                        $hasVerify = $rObj->getRequired() ? true : $hasField;

                        if ($hasVerify) {
                            // 进行规则验证
                            if (! $rObj->passes($data, $field, $options)) {
                                $errors[] = [$field, $command, $options, $rObj->getMessage()];
                                if (! $many) {
                                    return new ValidateMessage($valid->getMessages(), $errors);
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($errors) {
            return new ValidateMessage($valid->getMessages(), $errors);
        }
        return $data;
    }

    public function loadValidate($path, $namespace)
    {
        // 获取所有类文件
        $files = $this->loadValidateFiles($path);
        foreach ($files as $file) {
            $cls = str_replace($path, '', $file);
            $cls = str_replace('.php', '', $cls);
            $cls = str_replace('/', '\\', $cls);
            $cls = $namespace . $cls;
            $this->getValidate($cls);
        }
    }

    protected function loadValidateFiles($path)
    {
        $paths = [];
        $files = scandir($path);
        foreach ($files as $v) {
            if (! in_array($v, ['.', '..'])) {
                if (is_file($path . $v)) {
                    if (strpos($v, '.php') !== false) {
                        $paths[] = $path . $v;
                    }
                } else {
                    $paths = array_merge($paths, $this->loadValidateFiles($path . $v . '/'));
                }
            }
        }
        return $paths;
    }

    /**
     * 获取验证器（缓存起来防止下次解析过多消耗CUP）.
     * @param string $cls
     * @return Validate
     */
    protected function getValidate($cls)
    {
        if (! isset($this->validates[$cls])) {
            $obj = new $cls();
            $obj->setRules($this->parseRules($obj->getRules()));
            $this->validates[$cls] = $obj;
        }
        return $this->validates[$cls];
    }

    /**
     * @param array|string $arr
     * @return array
     */
    protected function parseRule($arr)
    {
        $arr1 = is_string($arr) ? explode('|', $arr) : $arr;
        $arr2 = [];
        foreach ($arr1 as $iStr) {
            if (is_string($iStr)) {
                if (strpos($iStr, ':') === false) {
                    $command = $iStr;
                    $options = [];
                } else {
                    $iStr2 = explode(':', $iStr);
                    $command = $iStr2[0];
                    $options = $iStr2[1];
                    if ($options) {
                        $options = explode(',', $options);
                    }
                }
                $arr2[] = [$command => $options];
            } else {
                $arr2[] = $iStr;
            }
        }
        return $arr2;
    }

    /**
     * @param array $rules
     * @return array
     */
    protected function parseRules($rules)
    {
        foreach ($rules as $field => $rule) {
            $rules[$field] = $this->parseRule($rule);
        }
        return $rules;
    }
}
