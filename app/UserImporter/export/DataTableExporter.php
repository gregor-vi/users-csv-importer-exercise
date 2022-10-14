<?php

namespace App\UserImporter\export;

use App\UserImporter\model\DataTable;

interface DataTableExporter {
    public function toFile(DataTable $dataTable, string $filename);
}