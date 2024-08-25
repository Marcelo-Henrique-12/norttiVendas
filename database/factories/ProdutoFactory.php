<?php

namespace Database\Factories;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    public function definition()
    {
        // Gera um nome aleatório para o produto
        $nome = ucfirst($this->faker->word());

        // URL para uma imagem aleatória
        $randomImageUrl = 'https://picsum.photos/200/200';

        // Faz o download da imagem aleatória
        $imageContents = Http::withoutVerifying()->get($randomImageUrl)->body();

        // Gera um nome aleatório para o arquivo da imagem
        $imageName = 'produto_' . Str::random(10) . '.jpg';
        $tempPath = 'produtosFotos/temp/' . $imageName;

        // Salva a imagem no diretório temporário
        Storage::disk('public')->put($tempPath, $imageContents);

        // Obtém um ID de categoria aleatória se tiver alguma criada, se não cria com a factory e pega uma
        $categoriaCount = Categoria::count();

        if ($categoriaCount == 0) {
            $categoriaId = Categoria::factory()->create();
        } else {
            $categoriaId = Categoria::inRandomOrder()->first()->id;
        }

        return [
            'nome' => $nome,
            'foto' => $tempPath, // Define o caminho temporário da imagem
            'valor' => $this->faker->randomFloat(2, 1, 1000),
            'categoria_id' => $categoriaId,
            'quantidade' => $this->faker->numberBetween(1, 100),
        ];
    }

    /**
     * Configura uma função de callback após a criação para mover a imagem para o diretório correto.
     */
    public function configure()
    {
        return $this->afterCreating(function (Produto $produto) {
            // Gera o caminho final para a imagem baseado no ID do produto
            $imageName = basename($produto->foto); // Obtém o nome do arquivo da imagem do caminho temporário
            $newPath = 'produtosFotos/' . $produto->id . '/' . $imageName;

            // Move a imagem do caminho temporário para o novo caminho
            Storage::disk('public')->move($produto->foto, $newPath);

            // Atualiza o atributo 'foto' do modelo com o novo caminho
            $produto->foto = $newPath;
            $produto->save();
        });
    }
}
