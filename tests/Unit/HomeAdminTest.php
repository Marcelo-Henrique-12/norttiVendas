<?php

namespace Tests\Unit;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_the_admin_dashboard()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get(route('admin.home'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.home');
    }
}
