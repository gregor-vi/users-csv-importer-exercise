<?php

namespace App\UserImporter;

use App\UserImporter\mapping\AttributesUuidMapping;
use App\UserImporter\mapping\UuidMapping;
use App\UserImporter\model\DataRow;
use App\UserImporter\model\DataTable;
use App\UserImporter\model\Entry;
use Symfony\Component\Console\Input\Input;

class UuidConverter {
    private UuidMapping $emailMap;
    private AttributesUuidMapping $attributesMap;
    private DataTable $inputDocument;

    function __construct(UuidMapping $emailMap, AttributesUuidMapping $attributesMap, DataTable $inputDocument) {
        $this->emailMap = $emailMap;
        $this->attributesMap = $attributesMap;
        $this->inputDocument = $inputDocument;
    }

    public function convert() : DataTable {
        $converted = array_map(fn ($row) => $this->convertRow($row), $this->inputDocument->getRows());
        return new DataTable($this->inputDocument->getColumns(), $converted);
    }

    /**
     * Converts a row of values into their corresponding uuids
     * @param DataRow $row
     * @return DataRow
     */
    private function convertRow(DataRow $row): DataRow {
        $emailUuid = $this->emailMap->get($row->getPrimary());
        $entries = array_map(function (Entry $entry) {
            return new Entry(
                $entry->name,
                $this->attributesMap->getAttrUuid($entry->name, $entry->value)
            );
        }, $row->getEntries());

        return new DataRow($emailUuid, $entries);
    }
}