<?php

namespace Tests\Unit;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PerfilAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // Testa se a página de perfil do administrador autenticado é exibida corretamente
    public function it_displays_the_profile_page_for_the_authenticated_admin()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $response = $this->get(route('admin.perfil.index'));
        $response->assertStatus(200);
        $response->assertViewHas('admin', $admin);
    }

    /** @test */
    // Testa se o perfil do administrador é atualizado corretamente
    public function it_updates_the_admin_profile_successfully()
    {
        // Cria e autentica um administrador
        $admin = Admin::factory()->create([
            'password' => Hash::make('old_password'),
        ]);
        $this->actingAs($admin, 'admin');

        $newData = [
            'nome' => 'Novo Nome Admin',
            'email' => 'novoemailadmin@example.com',
            'password' => 'new_password',
            'password_confirmation' => 'new_password'
        ];

        $response = $this->put(route('admin.perfil.update', $admin), $newData);

        $response->assertRedirect(route('admin.perfil.index'));
        $response->assertSessionHas('success', 'Perfil atualizado com sucesso!');

        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'nome' => 'Novo Nome Admin',
            'email' => 'novoemailadmin@example.com',
        ]);

        $this->assertTrue(Hash::check('new_password', $admin->fresh()->password));
    }

    /** @test */
    // Testa se a atualização do perfil é negada para outro administrador
    public function it_denies_admin_profile_update_for_another_admin()
    {
        $admin = Admin::factory()->create();
        $anotherAdmin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $newData = [
            'nome' => 'Nome Não Autorizado',
            'email' => 'email_nao_autorizado@example.com',
        ];

        $response = $this->put(route('admin.perfil.update', $anotherAdmin), $newData);

        $response->assertRedirect(route('admin.perfil.index'));
        $response->assertSessionHas('error', 'Não Autorizado!');

        $this->assertDatabaseMissing('admins', [
            'id' => $anotherAdmin->id,
            'nome' => 'Nome Não Autorizado',
            'email' => 'email_nao_autorizado@example.com',
        ]);
    }
}
