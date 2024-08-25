<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Venda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompraTest extends TestCase
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
    public function it_displays_the_user_purchases()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Venda::factory()->create(['user_id' => $user->id]);
        Venda::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('cliente.compras.index'));

        $response->assertStatus(200);

        $response->assertViewHas('compras');
        $response->assertViewHas('produtosComprados');
    }

    /** @test */
    public function it_shows_a_specific_purchase()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $venda = Venda::factory()->create(['user_id' => $user->id]);


        $response = $this->get(route('cliente.compras.show', $venda));

        $response->assertStatus(200);

        $response->assertViewHas('venda');
    }
}
