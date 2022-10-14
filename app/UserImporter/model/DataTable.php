<?php

namespace App\UserImporter\model;

class DataTable {
    private array $columns;

    /**
     * @var DataRow[]
     */
    private array $rows;

    public function __construct(array $headers = [], array $rows = []) {
        $this->columns = $headers;
        $this->rows = $rows;
    }

    function setColumns(array $columns): void {
        $this->columns = $columns;
    }

    function addRow(DataRow $row): void {
        $this->rows[] = $row;
    }

    /**
     * @return array
     */
    public function getColumns(): array {
        return $this->columns;
    }

    /**
     * @return array
     */
    public function getRows(): array {
        return $this->rows;
    }
}