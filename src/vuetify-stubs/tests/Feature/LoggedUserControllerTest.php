<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class LoggedUserControllerTest
 *
 * @package Tests\Feature
 */
class LoggedUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_update_his_own_info()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $response = $this->json('PUT','api/v1/user', [
            'email' => 'pepepardo@jeans.com',
            'name' => 'Pepe Pardo Jeans'
        ]);

        $response->assertSuccessful();

        $response->assertJson([
            'email' => 'pepepardo@jeans.com',
            'name' => 'Pepe Pardo Jeans',
        ]);

        $user = User::find($user->id);

        $this->assertEquals('Pepe Pardo Jeans',$user->name);
        $this->assertEquals('pepepardo@jeans.com',$user->email);
    }
}
