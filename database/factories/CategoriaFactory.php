<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition()
    {
        $nome = $this->faker->word();

        $randomImageUrl = 'https://picsum.photos/100/100';

        $imageContents = Http::withoutVerifying()->get($randomImageUrl)->body();
        $imageName = 'icone_' . Str::random(10) . '.jpg';
        $tempPath = 'icones/temp/' . $imageName;
        Storage::disk('public')->put($tempPath, $imageContents);

        $categoria = Categoria::create([
            'nome' => ucfirst($nome),
            'icone' => $tempPath,
            'descricao' => $this->faker->sentence(),
        ]);

        $newPath = 'icones/' . $categoria->id . '/' . $imageName;

        Storage::disk('public')->move($tempPath, $newPath);

        $categoria->icone = $newPath;
        $categoria->save();

        return $categoria->toArray();
    }
}
