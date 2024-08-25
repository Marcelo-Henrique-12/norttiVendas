<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoriaAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Configuração antes de cada teste.
     *
     * @return void
     */
    protected function setUp(): void
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
        parent::tearDown();
    }

    /**
     * Testa se a listagem de categorias é exibida corretamente.
     *
     * @return void
     */
    public function test_it_displays_categories_correctly()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $categorias = Categoria::factory()->count(20)->create();

        $response = $this->get(route('admin.categorias.index'));

        $response->assertViewIs('admin.categorias.index');

        $response->assertViewHas('categorias', function ($viewCategorias) use ($categorias) {
            return $viewCategorias->count() === 20 && $viewCategorias->contains($categorias->first());
        });

        $response->assertStatus(200);
    }

    /**
     * Testa a exibição do formulário de criação de categoria.
     *
     * @return void
     */
    public function test_it_displays_create_category_form()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get(route('admin.categorias.create'));

        $response->assertViewIs('admin.categorias.create');
        $response->assertStatus(200);
    }

    /**
     * Testa se a rota store e a criação de uma categoria é feita corretamente.
     *
     * @return void
     */
    public function test_it_creates_a_new_category()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $data = [
            'nome' => 'Categoria Teste',
            'icone' => UploadedFile::fake()->image('icone.jpg'),
            'descricao' => 'Descrição de teste para a categoria',
        ];

        $response = $this->post(route('admin.categorias.store'), $data);

        $this->assertDatabaseHas('categorias', [
            'nome' => 'Categoria Teste',
            'descricao' => 'Descrição de teste para a categoria',
        ]);

        $categoria = Categoria::where('nome', 'Categoria Teste')->first();
        Storage::disk('public')->assertExists($categoria->icone);

        $response->assertRedirect(route('admin.categorias.index'));
        $response->assertSessionHas('success', 'Categoria criada com sucesso!');
    }

    /**
     * Testa a exibição de uma categoria específica.
     *
     * @return void
     */
    public function test_it_displays_a_specific_category()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $categoria = Categoria::factory()->create([
            'nome' => 'Categoria Teste',
            'descricao' => 'Descrição de teste para a categoria',
        ]);

        $response = $this->get(route('admin.categorias.show', $categoria->id));

        $response->assertViewIs('admin.categorias.show');

        $response->assertViewHas('categoria', function ($viewCategoria) use ($categoria) {
            return $viewCategoria->id === $categoria->id &&
                $viewCategoria->nome === $categoria->nome &&
                $viewCategoria->descricao === $categoria->descricao;
        });

        $response->assertStatus(200);
    }

    /**
     * Testa a exibição do formulário de edição de categoria.
     *
     * @return void
     */
    public function test_it_displays_the_edit_form_for_a_category()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $categoria = Categoria::factory()->create([
            'nome' => 'Categoria Teste',
            'descricao' => 'Descrição de teste para a categoria',
        ]);

        $response = $this->get(route('admin.categorias.edit', $categoria->id));

        $response->assertViewIs('admin.categorias.edit');
        $response->assertViewHas('categoria', function ($viewCategoria) use ($categoria) {
            return $viewCategoria->id === $categoria->id &&
                $viewCategoria->nome === $categoria->nome &&
                $viewCategoria->descricao === $categoria->descricao;
        });

        $response->assertStatus(200);
    }

    /**
     * Testa a atualização de uma categoria existente.
     *
     * @return void
     */
    public function test_it_updates_a_category()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $categoria = Categoria::factory()->create();

        $newData = [
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Nova descrição de categoria.',
        ];

        $newIcon = UploadedFile::fake()->image('new_icon.jpg');

        $response = $this->put(route('admin.categorias.update', $categoria), array_merge($newData, ['icone' => $newIcon]));

        $response->assertRedirect(route('admin.categorias.index'));
        $response->assertSessionHas('success', 'Categoria atualizada com sucesso!');

        $categoria->refresh();

        $this->assertEquals($newData['nome'], $categoria->nome);
        $this->assertEquals($newData['descricao'], $categoria->descricao);
        Storage::disk('public')->assertExists($categoria->icone);
    }

    /**
     * Testa a remoção de uma categoria existente.
     *
     * @return void
     */
    public function test_it_deletes_a_category()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $categoria = Categoria::factory()->create([
            'icone' => 'icones/teste.jpg'
        ]);

        // Certifique-se de que o arquivo existe antes do teste
        Storage::disk('public')->put('icones/teste.jpg', 'conteúdo fake');
        Storage::disk('public')->assertExists('icones/teste.jpg');

        // Ação
        $response = $this->delete(route('admin.categorias.destroy', $categoria));

        // Verificações
        $response->assertRedirect(route('admin.categorias.index'));
        $response->assertSessionHas('success', 'Categoria deletada com sucesso!');

        // Verifica se a categoria foi removida do banco de dados
        $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);

        // **Atualização**: Verificar o caminho exato do arquivo
        Storage::disk('public')->assertMissing($categoria->icone);
    }
}
