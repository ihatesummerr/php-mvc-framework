<?php

namespace ihate\mvc\validation;

class Required extends Rule {

    public function validate($value): bool {
        if ($value) {
            return true;
        }
        return false;
    }

    public function message(): string {
        return 'This field is required';
    }

}