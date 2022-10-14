<?php

namespace App\Providers;

use App\UserImporter\export\DataTableJsonExporter;
use App\UserImporter\import\DataTableCsvImporter;
use App\UserImporter\mapping\AttributesUuidMapping;
use App\UserImporter\mapping\UuidMapping;
use App\UserImporter\UserImporter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserImporter::class, function () {
            $emailsMappingData = json_decode(file_get_contents(app_path('../data/mapping/emails.json')), true);
            $emailMapping = new UuidMapping($emailsMappingData, 'email');
            $filtersMappingData = json_decode(file_get_contents(app_path('../data/mapping/filters.json')), true);
            $attrMapping = new AttributesUuidMapping($filtersMappingData, 'en', [
                'Age range' => function(string $age) {
                    if ($age === '-26') {
                        return '- 26';
                    }
                    if ($age === '40') {
                        return '+ 40';
                    }

                    return $age;
                }
            ]);

            return new UserImporter(
                new DataTableCsvImporter(),
                $emailMapping,
                $attrMapping,
                new DataTableJsonExporter(),
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
