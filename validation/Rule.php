<?php

namespace app\core\validation;

abstract class Rule {

    protected string $name;
    
    public function name() {
        return $this->name;
    }

    public abstract function validate($value): bool;
    public abstract function message(): string;

}