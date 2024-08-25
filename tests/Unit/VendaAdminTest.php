<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Venda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VendaAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_sales_with_products_and_categories()
    {
        // Criar um admin e autenticar
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'admin');

        // Criar uma venda
        $venda = Venda::factory()->create();

        // Requisição para a rota
        $response = $this->get(route('admin.vendas.index'));

        // Verificar o status e o conteúdo da resposta
        $response->assertStatus(200);
        $response->assertViewIs('admin.vendas.index');

        // Verificar se os dados da venda estão presentes na view
        $response->assertViewHas('vendas');
        $response->assertViewHas('categorias');
        $response->assertViewHas('produtosVendidos');
    }

    public function test_it_displays_a_specific_sale()
    {
        // Crie um admin e autentique-se
        $admin = Admin::factory()->create([
            'password' => bcrypt('password'), // Defina a senha conforme necessário
        ]);

        $this->actingAs($admin, 'admin');

        // Crie uma venda para testar
        $venda = Venda::factory()->create();

        // Requisição para a rota de mostrar uma venda específica
        $response = $this->get(route('admin.vendas.show', $venda->id));

        // Verificar o status e o conteúdo da resposta
        $response->assertStatus(200);
        $response->assertViewIs('admin.vendas.show');

        // Verificar se a venda está presente na view
        $response->assertViewHas('venda', $venda);
    }
}
