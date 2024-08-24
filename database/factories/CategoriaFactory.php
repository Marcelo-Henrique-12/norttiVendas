<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition()
    {
        // Gera um nome aleatório para a categoria
        $nome = ucfirst($this->faker->word());

        // URL para uma imagem aleatória
        $randomImageUrl = 'https://picsum.photos/100/100';

        // Faz o download da imagem aleatória
        $imageContents = Http::withoutVerifying()->get($randomImageUrl)->body();

        // Gera um nome aleatório para o arquivo da imagem
        $imageName = 'icone_' . Str::random(10) . '.jpg';
        $tempPath = 'icones/temp/' . $imageName;

        // Salva a imagem no diretório temporário
        Storage::disk('public')->put($tempPath, $imageContents);

        return [
            'nome' => $nome,
            'descricao' => $this->faker->sentence(),
            // Define o caminho temporário da imagem como o ícone da categoria inicialmente
            'icone' => $tempPath,
        ];
    }

    /**
     * Configura uma função de callback após a criação para mover a imagem para o diretório correto.
     */
    public function configure()
    {
        return $this->afterCreating(function (Categoria $categoria) {
            // Gera o caminho final para a imagem baseada no ID da categoria
            $imageName = basename($categoria->icone); // Obtém o nome do arquivo da imagem do caminho temporário
            $newPath = 'icones/' . $categoria->id . '/' . $imageName;

            // Move a imagem do caminho temporário para o novo caminho
            Storage::disk('public')->move($categoria->icone, $newPath);

            // Atualiza o atributo 'icone' do modelo com o novo caminho
            $categoria->icone = $newPath;
            $categoria->save();
        });
    }
}
