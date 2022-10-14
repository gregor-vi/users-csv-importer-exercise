<?php

namespace App\UserImporter\mapping;

class UuidMapping {
    private array $map = [];
    private string $inputKey;
    private $normalizer;

    public function __construct(array $input, string $inputKey, ?callable $normalizer = null) {
        $this->inputKey = $inputKey;
        $this->initMapping($input);
        $this->normalizer = $normalizer;
    }

    public function get(string $key): ?string {
        if ($this->normalizer) {
            return $this->map[($this->normalizer)($key)] ?? null;
        }
        return $this->map[$key] ?? null;
    }

    private function initMapping(array $input) : void {
        $this->map =  array_reduce($input, function ($carry, $entry) {
            $carry[$entry[$this->inputKey]] = $entry['_id'];
            return $carry;
        }, []);
    }
}