<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PerfilClienteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // testa se a página de perfil do usuário autenticado é exibida corretamente
    public function it_displays_the_profile_page_for_the_authenticated_user()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('cliente.perfil.index'));
        $response->assertStatus(200);
        $response->assertViewHas('user', $user);
    }

    /** @test */
    // testa se o perfil do usuário é atualizado corretamente
    public function it_updates_the_profile_successfully()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old_password'),
        ]);
        $this->actingAs($user);

        $newData = [
            'name' => 'Novo Nome',
            'email' => 'novoemail@example.com',
            'password' => 'new_password',
            'password_confirmation' => 'new_password'
        ];

        $response = $this->put(route('cliente.perfil.update', $user), $newData);
        $response->assertRedirect(route('cliente.perfil.index'));
        $response->assertSessionHas('success', 'Perfil atualizado com sucesso!');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Novo Nome',
            'email' => 'novoemail@example.com',
        ]);
        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
    }

    /** @test */
    // testa se a atualização do perfil é negada para outro usuário
    public function it_denies_profile_update_for_another_user()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $this->actingAs($user);

        $newData = [
            'name' => 'Nome Não Autorizado',
            'email' => 'email_nao_autorizado@example.com',
        ];

        $response = $this->put(route('cliente.perfil.update', $anotherUser), $newData);
        $response->assertRedirect(route('cliente.perfil.index'));
        $response->assertSessionHas('error', 'Não Autorizado!');

        $this->assertDatabaseMissing('users', [
            'id' => $anotherUser->id,
            'name' => 'Nome Não Autorizado',
            'email' => 'email_nao_autorizado@example.com',
        ]);
    }
}
