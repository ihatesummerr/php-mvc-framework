<?php

namespace app\core\form;

use app\core\Model;

class InputField extends BaseField {

    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct($model, $attribute) {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    

    public function password() {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf('<input 
        class="form__input %s" 
        type="%s" 
        name="%s"
        value="%s"
        autocomplete="off" 
        placeholder="%s">',
        $this->model->hasError($this->attribute) ? 'form__input--is-invalid' : '', 
        $this->type,
        $this->attribute, 
        $this->model->{$this->attribute},
        $this->model->labels()[$this->attribute] ?? $this->attribute);
    }

}