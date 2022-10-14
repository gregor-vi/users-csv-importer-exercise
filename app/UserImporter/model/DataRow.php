<?php

namespace App\UserImporter\model;

class DataRow {
    private string $primary;
    /**
     * @var Entry[]
     */
    private array $entries;

    public function __construct(string $primary, array $entries) {
        $this->primary = $primary;
        $this->entries = $entries;
    }

    /**
     * @return string
     */
    public function getPrimary(): string {
        return $this->primary;
    }

    /**
     * @return array
     */
    public function getEntries(): array {
        return $this->entries;
    }
}