<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document_type = DocumentType::create([
            'name' => 'Cédula de ciudadanía'
        ]);

        $document_type = DocumentType::create([
            'name' => 'Cédula de extranjería'
        ]);

        $document_type = DocumentType::create([
            'name' => 'NIT'
        ]);
    }
}
