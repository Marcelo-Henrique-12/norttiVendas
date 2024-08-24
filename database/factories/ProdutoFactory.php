<?php

namespace Database\Factories;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    public function definition()
    {
        $nome = $this->faker->word();

        $randomImageUrl = 'https://picsum.photos/200/200';
        $imageContents = Http::withoutVerifying()->get($randomImageUrl)->body();
        $imageName = 'produto_' . Str::random(10) . '.jpg';
        $imagePath = 'produtosFotos/temp/' . $imageName;
        Storage::disk('public')->put($imagePath, $imageContents);

        $categoriaId = Categoria::inRandomOrder()->first()->id;

        $produto = Produto::create([
            'nome' => ucfirst($nome),
            'foto' => $imagePath,
            'valor' => $this->faker->randomFloat(2, 1, 1000),
            'categoria_id' => $categoriaId,
            'quantidade' => $this->faker->numberBetween(1, 100),
        ]);

        $newPath = 'icones/' . $produto->id . '/' . $imageName;

        Storage::disk('public')->move($imagePath, $newPath);

        $produto->foto = $newPath;
        $produto->save();

        return $produto->toArray();
    }
}
