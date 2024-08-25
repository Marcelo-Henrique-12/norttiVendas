<?php

namespace Tests\Feature;

use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeTest extends TestCase
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
    public function test_index_returns_correct_view_and_data()
    {
        Categoria::factory()->count(25)->create();

        $response = $this->get(route('cliente.home'));

        $response->assertStatus(200);
        $response->assertViewIs('cliente.home');

        $response->assertViewHas('categorias');
        $categorias = $response->viewData('categorias');

        $this->assertEquals(20, $categorias->count());
        $this->assertEquals(25, $categorias->total());
    }
}
