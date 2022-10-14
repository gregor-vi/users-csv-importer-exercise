<?php

namespace App\UserImporter\mapping;

/**
 * Maps filters and attributes to their corresponding database id's
 */
class AttributesUuidMapping {
    private array $map = [];
    private string $lang;
    private array $valueNormalizers;

    public function __construct(array $input, string $lang = 'en', $valueNormalizers = []) {
        $this->lang = $lang;
        $this->valueNormalizers = $valueNormalizers;
        $this->initMapping($input);
    }

    function getFilterUuid(string $attrName): ?string {
        return $this->map[$attrName]['id'] ?? null;
    }

    function getAttrUuid(string $attrName, string $attrValue): ?string {
        if (!isset($this->map[$attrName]['values'])) {
            return null;
        }

        return $this->map[$attrName]['values']->get($attrValue);
    }

    private function initMapping(array $input): void {
        $this->map = array_reduce($input, function ($acc, $row) {
            $filterName = $row['name'][$this->lang];
            $acc[$filterName] = [
                'id' => $row['_id'],
                'values' => new UuidMapping($row['values'], $this->lang, $this->valueNormalizers[$filterName] ?? null)
            ];

            return $acc;
        }, []);
    }
}