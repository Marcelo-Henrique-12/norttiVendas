<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;
use Illuminate\Support\Facades\Storage;

class ProdutoSeeder extends Seeder
{
    public function run()
    {
        Produto::factory()->count(100)->create();

    }
}
