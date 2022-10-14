## Description 

Locations of interest:

* app/UserImporter/*
  * main importer logic
* app/Console/Commands/UserImport.php 
  * the CLI command
* app/Providers/AppServiceProvider.php
  * adding the importer as an app service


The command will export a json file, as described in the requirements.

I didn't put emphasis on input validation, as I assumed the input csv file will be well formatted.
Instead I have noticed that the users.csv file contains "Age range" attributes that aren't found in the filters.json file, so the mapping can't be created.
Not sure it was intentional or not, but I added a sort of "normalizer" that would correct these attributes when looking for their mapped id.

Generally, it may look a little bit over-engineered, but I wanted to create a solution that would also illustrate the use of oop principles, dependency injection and separation of concerns.

## Usage

> php artisan user:import /path/to/csv-file

The command will export a file named out.json

