<?php

namespace app\core\validation;

class Max extends Rule {

    private int $max;

    public function __construct($params) {
        $this->max = $params['max'];
    }

    public function validate($value): bool {
        if (strlen($value) < $this->max) {
            return true;
        }
        return false;
    }

    public function message(): string {
        return "Max length of this field must be $this->max";
    }

}