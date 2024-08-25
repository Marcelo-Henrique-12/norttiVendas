<?php

namespace Tests\Unit;

use App\Models\Produto;
use App\Models\User;
use App\Models\Venda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CarrinhoTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    // verifica se a página de carrinho de compras está sendo exibida
    public function it_displays_carrinho_compras()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $produto1 = Produto::factory()->create(['nome' => 'Produto 1', 'valor' => 10.00]);
        $produto2 = Produto::factory()->create(['nome' => 'Produto 2', 'valor' => 20.00]);

        $carrinho = [
            $produto1->id => ['nome' => $produto1->nome, 'valor' => $produto1->valor, 'quantidade' => 2, 'foto' => 'foto1.jpg'],
            $produto2->id => ['nome' => $produto2->nome, 'valor' => $produto2->valor, 'quantidade' => 1, 'foto' => 'foto2.jpg'],
        ];

        $this->withSession(['carrinho' => $carrinho]);

        $response = $this->get(route('cliente.carrinho.index'));

        $response->assertStatus(200);
        $response->assertViewIs('cliente.carrinho.index');
        $response->assertViewHas('carrinho', $carrinho);

        foreach ($carrinho as $key => $item) {
            $response->assertSee($item['nome']);
            $response->assertSee(number_format($item['valor'], 2, ',', '.'));
            $response->assertSee($item['quantidade']);
        }
    }

    /** @test */
    // verifica se a função de adicionar ao carrinho está funcionando
    public function it_adds_a_product_to_the_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'valor' => 15.00,
            'quantidade' => 10,
        ]);

        $response = $this->post(route('cliente.carrinho.adicionar'), [
            'produto_id' => $produto->id,
            'quantidade' => 2,
        ]);

        $carrinho = session()->get('carrinho');
        $this->assertArrayHasKey($produto->id, $carrinho);
        $this->assertEquals(2, $carrinho[$produto->id]['quantidade']);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Produto adicionado ao carrinho!');
    }

    /** @test */
    // verifica se a função de adicionar ao carrinho não adiciona um produto esgotado
    public function it_does_not_add_an_out_of_stock_product_to_the_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $produto = Produto::factory()->create([
            'nome' => 'Produto Esgotado',
            'valor' => 15.00,
            'quantidade' => 0, // Produto esgotado
        ]);

        $response = $this->post(route('cliente.carrinho.adicionar'), [
            'produto_id' => $produto->id,
            'quantidade' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Este produto está esgotado e não pode ser adicionado ao carrinho.');
    }

    /** @test */
    // verifica se a função de adicionar ao carrinho redireciona para a página de carrinho de compras
    public function it_redirects_to_cart_page_when_action_is_comprar()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'valor' => 15.00,
            'quantidade' => 10,
        ]);

        $response = $this->post(route('cliente.carrinho.adicionar'), [
            'produto_id' => $produto->id,
            'quantidade' => 2,
            'action' => 'comprar',
        ]);

        $response->assertRedirect(route('cliente.carrinho.index'));
        $response->assertSessionHas('success', 'Produto adicionado ao carrinho e pronto para finalizar a compra!');
    }

    /** @test */
    // verifica se a função de decrementar o item do carrinho de compras está funcionando
    public function it_decreases_product_quantity_in_the_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'valor' => 15.00,
            'quantidade' => 10,
        ]);

        session()->put('carrinho', [
            $produto->id => [
                'nome' => $produto->nome,
                'quantidade' => 5,
                'valor' => $produto->valor,
                'foto' => $produto->getFotoUrlAttribute()
            ]
        ]);

        $response = $this->post(route('cliente.carrinho.atualizar', ['produto' => $produto->id]), [
            'quantidade' => 2,
            'action' => 'decrementar',
        ]);

        $carrinho = session()->get('carrinho');
        $this->assertEquals(3, $carrinho[$produto->id]['quantidade']);

        $response->assertRedirect(route('cliente.carrinho.index'));
        $response->assertSessionHas('success', 'Carrinho atualizado com sucesso!');
    }


    /** @test */
    // verifica se a função de remover o item do carrinho de compras está funcionando
    public function it_removes_a_product_from_the_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'valor' => 15.00,
            'quantidade' => 10,
        ]);

        session()->put('carrinho', [
            $produto->id => [
                'nome' => $produto->nome,
                'quantidade' => 5,
                'valor' => $produto->valor,
                'foto' => $produto->getFotoUrlAttribute()
            ]
        ]);

        $response = $this->post(route('cliente.carrinho.atualizar', ['produto' => $produto->id]), [
            'action' => 'remover',
        ]);

        $carrinho = session()->get('carrinho');
        $this->assertArrayNotHasKey($produto->id, $carrinho);

        $response->assertRedirect(route('cliente.carrinho.index'));
        $response->assertSessionHas('success', 'Carrinho atualizado com sucesso!');
    }

    /** @test */
    // verifica se caso o produto não esteja no carrinho, é exibida uma mensagem de erro
    public function it_shows_error_when_product_not_in_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'valor' => 15.00,
            'quantidade' => 10,
        ]);

        $response = $this->post(route('cliente.carrinho.atualizar', ['produto' => $produto->id]), [
            'action' => 'decrementar',
        ]);

        $response->assertRedirect(route('cliente.carrinho.index'));
        $response->assertSessionHas('error', 'Produto não encontrado no carrinho!');
    }


    /** @test */
    // testa a função que verifica se o carrinho está vazio antes de finalizar a compra

    public function it_redirects_to_home_if_cart_is_empty()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $produto = Produto::factory()->create();
        $response = $this->post(route('cliente.carrinho.compra'), [
            'total' => 0,
            'produtos' => [
                ['id' =>  $produto->id, 'quantidade' => 1, 'valor' => $produto->valor]
            ],
        ]);

        $response->assertRedirect(route('cliente.home'));
        $response->assertSessionHas('error', 'Carrinho vazio, adicione produtos antes de finalizar a compra!');
    }

    /** @test */
    // testa se a compra é finalizada com sucesso
    public function it_completes_the_purchase_successfully()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $produto = Produto::factory()->create(['quantidade' => 10, 'valor' => 15]);


        session()->put('carrinho', [
            $produto->id => [
                'nome' => $produto->nome,
                'quantidade' => 5,
                'valor' => $produto->valor,
                'foto' => $produto->getFotoUrlAttribute(),
            ],
        ]);

        $response = $this->post(route('cliente.carrinho.compra'), [
            'total' => 75, // 15 * 5
            'produtos' => [
                [
                    'id' => $produto->id,
                    'quantidade' => 5,
                    'valor' => $produto->valor,
                ],
            ],
        ]);

        $response->assertRedirect(route('cliente.compras.index'));
        $response->assertSessionHas('success', 'Compra realizada com sucesso!');

        $this->assertDatabaseHas('vendas', [
            'user_id' => $user->id,
            'total' => 75,
        ]);

        $this->assertDatabaseHas('vendas_produtos', [
            'venda_id' => Venda::latest()->first()->id,
            'produto_id' => $produto->id,
            'quantidade' => 5,
            'valor_produto' => $produto->valor,
        ]);

        $produto->refresh();
        $this->assertEquals(5, $produto->quantidade); // 10 - 5
    }
}
