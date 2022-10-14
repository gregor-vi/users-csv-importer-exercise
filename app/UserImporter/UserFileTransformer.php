<?php

namespace App\UserImporter;

use App\UserImporter\export\DataTableExporter;
use App\UserImporter\export\DataTableJsonExporter;
use App\UserImporter\import\DataTableCsvImporter;
use App\UserImporter\import\DataTableImporter;
use App\UserImporter\mapping\AttributesUuidMapping;
use App\UserImporter\mapping\UuidMapping;

class UserFileTransformer {
    private DataTableImporter $importer;
    private UuidMapping $emailsMap;
    private AttributesUuidMapping $attributesMap;
    private DataTableExporter $exporter;

    /**
     * @param DataTableImporter $importer
     * @param UuidMapping $emailMap
     * @param AttributesUuidMapping $attributesMap
     * @param DataTableExporter $exporter
     */
    public function __construct(
        DataTableImporter     $importer,
        UuidMapping           $emailMap,
        AttributesUuidMapping $attributesMap,
        DataTableExporter     $exporter
    ) {
        $this->importer = $importer;
        $this->emailsMap = $emailMap;
        $this->attributesMap = $attributesMap;
        $this->exporter = $exporter;
    }

    public function transform(string $inputFilename, string $outputFilename): void {
        $inputTable = $this->importer->createDataTable($inputFilename);
        $outTable = (new UuidConverter(
            $this->emailsMap,
            $this->attributesMap,
            $inputTable)
        )->convert();
        $this->exporter->toFile($outTable, $outputFilename);
    }
}