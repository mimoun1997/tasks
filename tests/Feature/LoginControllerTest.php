<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_login_a_user()
    {
        //1
        $user = factory(User::class)->create([
            'email' => 'prova@gmail.com'
        ]);

        $this->assertNull(Auth::user());

        // 2
        $response = $this->post('/login',[
            'email' => 'prova@gmail.com', //$user->email
            'password' => 'secret' // password per defecte de les factories Laravel
        ]);
//        dd($response);
        $response->assertStatus(302);
        $response->assertRedirect('/home');
        $this->assertNotNull(Auth::user());
        $this->assertEquals('prova@gmail.com',Auth::user()->email);
    }

    /**
     * @test
     */
    public function cannot_login_an_user_with_incorrect_password()
    {
//        $this->withoutExceptionHandling();
        //1
        $user = factory(User::class)->create([
            'email' => 'prova@gmail.com'
        ]);

        $this->assertNull(Auth::user());

        // 2
        $response = $this->post('/login',[
            'email' => 'prova@gmail.com', //$user->email
            'password' => 'asdjaskdlasdasd0798asdjh' //secret
        ]);
//        dd($response);
//        dump(Session::get('errors')[0]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertNull(Auth::user());
    }

    /**
     * @test
     */
    public function cannot_login_an_user_with_incorrec_user()
    {
//        $this->withoutExceptionHandling();
        //1
        $user = factory(User::class)->create([
            'email' => 'prova@gmail.com'
        ]);

        $this->assertNull(Auth::user());

        // 2
        $response = $this->post('/login',[
            'email' => 'incorrecte@gmail.com', //$user->email
            'password' => 'secret'
        ]);
//        dd($response);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertNull(Auth::user());
    }
}
