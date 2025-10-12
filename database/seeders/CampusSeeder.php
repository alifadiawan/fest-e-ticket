<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;


class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = database_path('../public/cleaned_campus.csv');

        if (!file_exists($file)) {
            $this->command->error("CSV file not found: {$file}");
            return;
        }

        if (($handle = fopen($file, 'r')) !== false) {
            $header = fgetcsv($handle); // read header row
            $data = [];

            while (($row = fgetcsv($handle)) !== false) {
                // Match CSV columns to database fields
                $data[] = [
                    'campus_name' => $row[0] ?? '',
                    'alamat'      => $row[1] ?? '',
                    'kota'        => $row[2] ?? '',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            fclose($handle);

            if (!empty($data)) {
                DB::table('campus')->insert($data);
                $this->command->info(count($data) . " campus records inserted.");
            } else {
                $this->command->warn("No data found in CSV.");
            }
        } else {
            $this->command->error("Unable to open file: {$file}");
        }
    }
}
