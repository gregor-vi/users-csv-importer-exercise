<?php

namespace App\Console\Commands;

use App\UserImporter\mapping\AttributesUuidMapping;
use App\UserImporter\import\DataTableCsvImporter;
use App\UserImporter\export\DataTableJsonExporter;
use App\UserImporter\mapping\UuidMapping;
use App\UserImporter\UserFileTransformer;
use App\UserImporter\UuidConverter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UserImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     **/
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(UserFileTransformer $userImporter)
    {
        $inputFile = $this->argument('file');
        $outFile = 'out.json';

        $userImporter->transform($inputFile, $outFile);
        $this->info("Created file: ${outFile}");
    }
}
