<?php

namespace App\UserImporter\import;

use App\UserImporter\model\DataRow;
use App\UserImporter\model\DataTable;
use App\UserImporter\model\Entry;

/**
 * Creates a DataTable from a csv file
 */
class DataTableCsvImporter implements DataTableImporter {
    public function createDataTable(string $input): DataTable {
        $dataTable = new DataTable();
        $file = fopen($input, 'r');
        $row = 0;
        while (($line = fgetcsv($file, null, ';')) !== false) {
            if ($row++ === 0) {
                $dataTable->setColumns($line);
                continue;
            }

            $columns = $dataTable->getColumns();
            $attributes = array_slice($line, 1);
            $entries = array_map(
                fn ($value, $k) => new Entry($columns[$k+1], $value),
                $attributes,
                array_keys($attributes),
            );

            $dataTable->addRow(new DataRow($line[0], $entries));
        }
        fclose($file);

        return $dataTable;
    }
}