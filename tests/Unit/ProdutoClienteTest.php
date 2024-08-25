<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProdutoClienteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */


    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /**
     * Limpeza após cada teste.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        // Limpa qualquer ícone remanescente do teste
        Storage::disk('public')->deleteDirectory('icones');
        Storage::disk('public')->deleteDirectory('produtosFotos');
        parent::tearDown();
    }
    // Testa se a página inicial dos produtos para o cliente é exibida corretamente
    public function test_index_returns_correct_view_and_data()
    {
        Categoria::factory()->count(3)->create();
        $produtos = Produto::factory()->count(25)->create();

        $carrinho = [
            $produtos[0]->id => ['quantidade' => 2],
            $produtos[1]->id => ['quantidade' => 1],
        ];
        session()->put('carrinho', $carrinho);

        $response = $this->get(route('cliente.produtos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('cliente.produtos.index');

        $response->assertViewHas('categorias');
        $response->assertViewHas('produtos');
        $response->assertViewHas('quantidadeCarrinho');

        $viewCategorias = $response->viewData('categorias');
        $viewProdutos = $response->viewData('produtos');
        $viewQuantidadeCarrinho = $response->viewData('quantidadeCarrinho');

        $this->assertCount(3, $viewCategorias);
        $this->assertEquals(20, $viewProdutos->count());
        $this->assertEquals(25, $viewProdutos->total());

        $this->assertArrayHasKey($produtos[0]->id, $viewQuantidadeCarrinho);
        $this->assertEquals(2, $viewQuantidadeCarrinho[$produtos[0]->id]);

        $this->assertArrayHasKey($produtos[1]->id, $viewQuantidadeCarrinho);
        $this->assertEquals(1, $viewQuantidadeCarrinho[$produtos[1]->id]);
    }
}
