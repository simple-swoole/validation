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

class Rule
{
    /** @var bool 是否要求字段不管是否存在必须验证 */
    protected $required = false;

    /** @var string 命令 */
    protected $command = 'required';

    /** @var string 错误消息 */
    protected $message = ':attribute require';

    /**
     * 获取指令.
     * @return bool
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * 是否必须验证
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function passes(ValidationData $validateData, $field, $options = [])
    {
        return true;
    }
}
