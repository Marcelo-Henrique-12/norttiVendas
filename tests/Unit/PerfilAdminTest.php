<?php

namespace Tests\Unit;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PerfilAdminTest extends TestCase
{
    public function test_it_displays_admin_profile()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get(route('admin.perfil.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.perfil.index');
        $response->assertViewHas('admin', function ($viewAdmin) use ($admin) {
            return $viewAdmin->id === $admin->id &&
                $viewAdmin->nome === $admin->nome;
        });
    }

    public function test_it_updates_admin_profile()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        // Cria um email único para o novo admin
        $uniqueEmail = 'uniqueemail' . time() . '@example.com';

        $newData = [
            'nome' => 'Novo Nome',
            'email' => $uniqueEmail,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword'
        ];

        // Ação
        $response = $this->put(route('admin.perfil.update', $admin), $newData);

        // Verificações
        $response->assertRedirect(route('admin.perfil.index'));
        $response->assertSessionHas('success', 'Perfil atualizado com sucesso!');

        // Recarrega o administrador atualizado
        $admin->refresh();

        // Verifica se os dados foram atualizados
        $this->assertEquals('Novo Nome', $admin->nome);
        $this->assertEquals($uniqueEmail, $admin->email);
        $this->assertTrue(Hash::check('newpassword', $admin->password));
    }

    public function test_it_does_not_allow_update_of_another_admin_profile()
    {
        // Cria dois administradores com emails únicos
        $admin1 = Admin::factory()->create(['email' => 'uniqueemail1@example.com']);
        $admin2 = Admin::factory()->create(['email' => 'uniqueemail2@example.com']);
        $this->actingAs($admin1, 'admin');

        // Define dados para atualizar
        $newData = [
            'nome' => 'Novo Nome',
            'email' => 'uniqueemail3@example.com',
        ];

        // Ação
        $response = $this->put(route('admin.perfil.update', $admin2), $newData);

        // Verificações
        $response->assertRedirect(route('admin.perfil.index'));
        $response->assertSessionHas('error', 'Não Autorizado!');
    }
}
