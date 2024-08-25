<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProdutoAdminTest extends TestCase
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

    // Testa se a listagem de produtos e categorias é exibida corretamente para o administrador.
    public function it_displays_a_list_of_products_and_categories()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $categorias = Categoria::factory()->count(3)->create();
        $produtos = Produto::factory()->count(5)->create();

        $response = $this->get(route('admin.produtos.index'));

        $response->assertStatus(200);

        foreach ($categorias as $categoria) {
            $response->assertSee($categoria->nome);
        }

        foreach ($produtos as $produto) {
            $response->assertSee($produto->nome);
        }
    }


    //testa se o formulário de criação de produto é exibido corretamente.
    public function test_it_displays_create_product_form()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get(route('admin.produtos.create'));

        $response->assertViewIs('admin.produtos.create');
        $response->assertStatus(200);
    }


    /** @test */

    // Testa se  a criação é realizada corretamente.
    public function it_creates_a_new_product()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $categoria = Categoria::factory()->create();

        $data = [
            'nome' => 'Produto Teste',
            'categoria_id' => $categoria->id,
            'valor' => 100.00,
            'quantidade' => 10,
            'foto' => UploadedFile::fake()->image('foto-produto.jpg'),
        ];

        $response = $this->post(route('admin.produtos.store'), $data);

        $this->assertDatabaseHas('produtos', [
            'nome' => 'Produto Teste',
            'categoria_id' => $categoria->id,
            'valor' => 100.00,
            'quantidade' => 10,
        ]);

        $produto = Produto::where('nome', 'Produto Teste')->first();
        Storage::disk('public')->assertExists($produto->foto);

        $response->assertRedirect(route('admin.produtos.index'));
        $response->assertSessionHas('success', 'Produto criado com sucesso!');
    }


    /** @test */
    // Testa se os detalhes do produto são exibidos corretamente.
    public function it_displays_the_product_details()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $categoria = Categoria::factory()->create();

        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'categoria_id' => $categoria->id,
            'valor' => 100.00,
            'quantidade' => 10,
        ]);

        $response = $this->get(route('admin.produtos.show', $produto->id));

        $response->assertViewIs('admin.produtos.show');

        $response->assertViewHas('produto', function ($viewProduto) use ($produto) {
            return $viewProduto->id === $produto->id;
        });

        $response->assertStatus(200);
    }


    /** @test */

    // Testa se o formulário de edição de produto é exibido corretamente.
    public function it_displays_the_edit_product_form()
    {
        // Crie um administrador e autentique
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        // Crie algumas categorias e um produto associado
        $categorias = Categoria::factory()->count(3)->create();
        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'categoria_id' => $categorias->first()->id,
            'valor' => 100.00,
            'quantidade' => 10,
        ]);

        // Envie uma solicitação GET para a rota 'admin.produtos.edit'
        $response = $this->get(route('admin.produtos.edit', $produto->id));

        // Verifique se a view correta é retornada
        $response->assertViewIs('admin.produtos.edit');

        // Verifique se as variáveis 'produto' e 'categorias' estão presentes na view
        $response->assertViewHas('produto', function ($viewProduto) use ($produto) {
            return $viewProduto->id === $produto->id &&
                $viewProduto->nome === $produto->nome &&
                $viewProduto->categoria_id === $produto->categoria_id;
        });

        $response->assertViewHas('categorias', function ($viewCategorias) use ($categorias) {
            return $viewCategorias->count() === $categorias->count() &&
                $viewCategorias->pluck('id')->sort()->values()->toArray() === $categorias->pluck('id')->sort()->values()->toArray();
        });

        // Verifique se o status da resposta é 200
        $response->assertStatus(200);
    }

    /** @test */
    // Testa se a atualização de um produto existente é realizada corretamente.

    public function test_it_updates_an_existing_product()
    {
        // Simula o armazenamento
        Storage::fake('public');

        // Crie um administrador e autentique
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        // Crie uma categoria
        $categoria = Categoria::factory()->create();

        // Crie um produto existente com uma foto fake
        $fotoAntiga = UploadedFile::fake()->image('foto_antiga.jpg');
        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'valor' => 100.00,
            'quantidade' => 10,
            'foto' => $fotoAntiga->store('produtosFotos')
        ]);

        // Crie uma nova foto fake para atualizar
        $novaFoto = UploadedFile::fake()->image('nova_foto.jpg');

        // Dados para atualizar o produto
        $dadosAtualizados = [
            'nome' => 'Produto Atualizado',
            'categoria_id' => $categoria->id,
            'valor' => 200.00,
            'quantidade' => 20,
            'foto' => $novaFoto
        ];

        // Envie uma solicitação PUT para atualizar o produto
        $response = $this->put(route('admin.produtos.update', $produto->id), $dadosAtualizados);

        // Verifique o redirecionamento e a mensagem de sucesso
        $response->assertRedirect(route('admin.produtos.index'));
        $response->assertSessionHas('success', 'Produto atualizado com sucesso!');

        // Verifique se os dados do produto foram atualizados no banco de dados
        $produto->refresh();
        $this->assertEquals('Produto Atualizado', $produto->nome);
        $this->assertEquals($categoria->id, $produto->categoria_id);
        $this->assertEquals(200.00, $produto->valor);
        $this->assertEquals(20, $produto->quantidade);
    }

    /** @test */
    // Testa se a remoção de um produto existente é realizada corretamente.
    public function test_it_deletes_an_existing_product()
    {
        // Simula o armazenamento
        Storage::fake('public');

        // Crie um administrador e autentique
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        // Crie uma categoria
        $categoria = Categoria::factory()->create();

        // Crie um produto com uma foto fake
        $foto = UploadedFile::fake()->image('foto.jpg');
        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'valor' => 100.00,
            'quantidade' => 10,
            'foto' => $foto->store('produtosFotos')
        ]);

        // Envie uma solicitação DELETE para remover o produto
        $response = $this->delete(route('admin.produtos.destroy', $produto->id));

        // Verifique o redirecionamento e a mensagem de sucesso
        $response->assertRedirect(route('admin.produtos.index'));
        $response->assertSessionHas('success', 'Produto deletado com sucesso!');

        // Verifique se a foto foi removida
        Storage::disk('public')->assertMissing('produtosFotos/' . basename($produto->foto));

        // Verifique se o produto foi removido do banco de dados
        $this->assertDatabaseMissing('produtos', [
            'id' => $produto->id
        ]);
    }
}
