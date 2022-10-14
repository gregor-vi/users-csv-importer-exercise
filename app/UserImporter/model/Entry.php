<?php

namespace App\UserImporter\model;

class Entry {
    public string $name;
    public ?string $value;

    /**
     * @param string $name
     * @param string|null $value
     */
    public function __construct(string $name, ?string $value) {
        $this->name = $name;
        $this->value = $value;
    }
}
