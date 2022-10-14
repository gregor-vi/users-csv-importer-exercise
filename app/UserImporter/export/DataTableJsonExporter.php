<?php

namespace App\UserImporter\export;

use App\UserImporter\model\DataRow;
use App\UserImporter\model\DataTable;
use App\UserImporter\model\Entry;
use JetBrains\PhpStorm\NoReturn;

class DataTableJsonExporter implements DataTableExporter {
    public function toFile(DataTable $dataTable, string $filename) {
        $exportData = array_map(
            fn (DataRow $row) => [
                '_id' => $row->getPrimary(),
                'attributes' => array_map(fn (Entry $entry)=> $entry->value, $row->getEntries()),
            ],
            $dataTable->getRows()
        );

        file_put_contents($filename, json_encode($exportData));
    }
}