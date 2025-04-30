<?php

class BaseResult
{
    // Свойства
    public $ErrorMessage;
    public $ErrorCode;
    public $ObjectName;
    public $data;
    public $connectionTime;

    // Метод для проверки успеха
    public function isSuccess() {
        return $this->ErrorMessage === null;
    }
}
?>