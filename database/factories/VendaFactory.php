<?php

namespace Database\Factories;

use App\Models\Venda;
use App\Models\User;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendaFactory extends Factory
{
    protected $model = Venda::class;

    public function definition()
    {
        return [
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Configura uma função de callback após a criação para adicionar produtos à venda.
     */
    public function configure()
    {
        return $this->afterCreating(function (Venda $venda) {
            // Garante que há produtos suficientes
            if (Produto::count() < 3) {
                Produto::factory()->count(3)->create();
            }

            $produtos = Produto::inRandomOrder()->take(3)->get();

            foreach ($produtos as $produto) {
                $venda->produtos()->attach($produto->id, [
                    'quantidade' => rand(1, 5), // Quantidade aleatória entre 1 e 5
                    'valor_produto' => $produto->valor,
                ]);
            }
        });
    }
}
