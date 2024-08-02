<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            ['name' => 'CC'],
            ['name' => 'NIT'],
            ['name' => 'PASAPORTE'],
            ['name' => 'NIE'],
            ['name' => 'DNI'],
        ];

        DB::table('document_types')->insert($documentTypes);
    }
}
