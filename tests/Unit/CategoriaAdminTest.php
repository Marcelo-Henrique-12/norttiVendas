<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoriaAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se a listagem de categorias é exibida corretamente.
     *
     * @return void
     */
    public function test_it_displays_categories_correctly()
    {
        // Cria um admin e autentica
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        // Cria categorias de teste
        $categorias = Categoria::factory()->count(20)->create();

        // Faz uma requisição GET para a rota index
        $response = $this->get(route('admin.categorias.index'));

        // Verifica se a visualização correta é retornada
        $response->assertViewIs('admin.categorias.index');

        // Verifica se as categorias são passadas para a visualização
        $response->assertViewHas('categorias', function ($viewCategorias) use ($categorias) {
            return $viewCategorias->count() === 20 && $viewCategorias->contains($categorias->first());
        });

        // Verifica o status da resposta
        $response->assertStatus(200);
    }
}
