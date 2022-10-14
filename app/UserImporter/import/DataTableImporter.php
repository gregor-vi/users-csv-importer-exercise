<?php

namespace App\UserImporter\import;

use App\UserImporter\model\DataTable;

interface DataTableImporter {
    public function createDataTable(string $input): DataTable;
}