<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    protected $user;
    protected $user_admin;
    protected $name;
    protected $name_admin;
    protected $email;
    protected $email_admin;
    protected $password;
    protected $password_admin;

    protected function setUp(): void{
        parent::setUp();
        $this->name = 'lesha';
        $this->name_admin = 'lesha_admin';
        $this->email = 'lesha@mail.ru';
        $this->email_admin = 'lesha_admin@mail.ru';
        $this->password = 'password';
        
        $this->user = User::create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'remember_token' => Str::random(10),
        ]);
        Contact::create([
            'user_id' => $this->user->id,
            'name' => $this->name,
        ]);

        $this->user_admin = User::create([
            'email' => $this->email_admin,
            'password' => Hash::make($this->password),
            'remember_token' => Str::random(10),
        ]);
        $this->user_admin->admin = 1;
        Contact::create([
            'user_id' => $this->user_admin->id,
            'name' => $this->name_admin,
        ]);
    }

    public function test_login_form_with_no_authentication()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('login');
    }
    public function test_login_form_with_authentication()
    {
        $response = $this->actingAs($this->user)->get('/login');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_login_act_with_no_post_request()//?????
    {
        $response = $this->post('/login-handler');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
    public function test_login_act_with_correct_data()//
    {
        $response = $this->post('/login-handler', [
            'email' => $this->email,
            'password' => $this->password,
        ]);
        $this->assertAuthenticated();
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_login_act_with_wrong_data()
    {
        $response = $this->post('/login-handler', [
            'email' => $this->email.'1',
            'password' => $this->password.'1',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHas('flash', 'Неправильный логин или пароль.');
        $response->assertRedirect('/login');
    }

    public function test_register_form_with_no_authentication()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('register');
    }
    public function test_register_form_with_authentication(){
        $response = $this->actingAs($this->user)->get('/register');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_register_act_with_correct_data(){
        $response = $this->post('/register-handler', [
            'name' => 'Lesha1',
            'email' => 'lesh12@mail.ru',
            'password' => $this->password,
        ]);
        $response->assertRedirect('/login');
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'email' => 'lesh12@mail.ru',
        ]);
        $this->assertDatabaseHas('contacts', [
            'name' => 'Lesha1',
        ]);
    }
    public function test_register_act_with_no_post_request(){//?????
        $response = $this->post('/register-handler');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_register_act_with_empty_fields(){
        $response = $this->post('/register-handler', [
            'name' => '',
            'email' => '',
            'password' => '',
        ]);
        $response->assertSessionHasErrors([
            'name' => 'Заполните обязательное поле.',
            'email' => 'Заполните обязательное поле.',
            'password' => 'Заполните обязательное поле.',
        ]);
        $response->assertStatus(302);
    }
    public function test_register_act_with_existed_email_and_short_password(){
        $response = $this->post('/register-handler', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => 'qw',
        ]);
        $response->assertSessionHasErrors([
            'email' => 'Данный email уже существует.',
            'password' => 'Пароль должен быть от 5 до 10 символов.',
        ]);
        $response->assertStatus(302);
    }

    public function test_users_pages_with_authentication()
    {
        $response = $this->actingAs($this->user)->get('/');
        $response->assertStatus(200);
        $this->assertAuthenticated();
    }
    public function test_users_page_with_no_authentication()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertGuest();
    }




    
    public function test_status_form_with_authentication()
    {
        $response = $this->actingAs($this->user)->get('/status/'.$this->user->id);
        $response->assertStatus(200);
        $this->assertAuthenticated();
    }
    public function test_status_form_with_not_existing_id()
    {
        $response = $this->actingAs($this->user)->get('/status/'.$this->user_admin->id+1);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_status_form_with_not_own_id()
    {
        $response = $this->actingAs($this->user)->get('/status/'.$this->user_admin->id);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_status_form_with_not_own_id_being_admin()
    {
        $response = $this->actingAs($this->user_admin)->get('/status/'.$this->user->id);
        $response->assertStatus(200);
    }
    public function test_status_act()
    {
        $response = $this->actingAs($this->user)->post('/status-handler/'.$this->user->id, [
            'status' => 'Онлайн',
        ]);
        $this->assertDatabaseHas('contacts', [
            'user_id' => $this->user->id,
            'status' => 'Онлайн',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_status_act_with_no_post_request()
    {
        $response = $this->actingAs($this->user)->post('/status-handler/'.$this->user->id);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }





    public function test_delete_act_yourself()
    {
        $response = $this->actingAs($this->user)->get('/delete-handler/'.$this->user->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id,
        ]);
        $response->assertRedirect('/login');
    }
    public function test_delete_act_with_no_authentication()
    {
        $response = $this->get('/delete-handler/'.$this->user->id);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
        ]);
        $response->assertRedirect('/login');
    }
    public function test_delete_act_not_own_id()
    {
        $response = $this->actingAs($this->user)->get('/delete-handler/'.$this->user_admin->id);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $this->user_admin->id,
        ]);
        $response->assertRedirect('/');
    }
    public function test_delete_act_not_own_id_being_admin()
    {
        $response = $this->actingAs($this->user_admin)->get('/delete-handler/'.$this->user->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id,
        ]);
        $response->assertRedirect('/');
    }





    public function test_edit_form_with_authentication()
    {
        $response = $this->actingAs($this->user)->get('/edit/'.$this->user->id);
        $response->assertStatus(200);
    }
    public function test_edit_form_with_no_authentication()
    {
        $response = $this->get('/edit/'.$this->user->id);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
    public function test_edit_form_with_not_existing_id()
    {
        $response = $this->actingAs($this->user)->get('/edit/'.$this->user_admin->id+1);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_edit_form_with_not_own_id()
    {
        $response = $this->actingAs($this->user)->get('/edit/'.$this->user_admin->id);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_edit_form_with_not_own_id_being_admin()
    {
        $response = $this->actingAs($this->user_admin)->get('/edit/'.$this->user->id);
        $response->assertStatus(200);
    }
    public function test_edit_act()
    {
        $response = $this->actingAs($this->user)->post('/edit-handler/'.$this->user->id, [
            'name' => 'Andrew',
            'position' => 'Developer',
            'phone' => '89726351829',
            'address' => 'ул. Пушкина',
        ]);
        $this->assertDatabaseHas('contacts', [
            'user_id' => $this->user->id,
            'name' => 'Andrew',
            'position' => 'Developer',
            'phone' => '89726351829',
            'address' => 'ул. Пушкина',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_edit_act_with_no_post_request()
    {
        $response = $this->post('/edit-handler/'.$this->user->id);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }





    public function test_security_form_with_authentication()
    {
        $response = $this->actingAs($this->user)->get('/security/'.$this->user->id);
        $response->assertStatus(200);
    }
    public function test_security_form_with_no_authentication()
    {
        $response = $this->get('/security/'.$this->user->id);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
    public function test_security_form_with_not_existing_id()
    {
        $response = $this->actingAs($this->user_admin)->get('/security/'.$this->user_admin->id+100);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_security_form_with_not_own_id()
    {
        $response = $this->actingAs($this->user)->get('/security/'.$this->user_admin->id);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function test_security_form_with_not_own_id_being_admin()
    {
        $response = $this->actingAs($this->user_admin)->get('/security/'.$this->user->id);
        $response->assertStatus(200);
    }
    public function test_security_act()
    {
        $response = $this->actingAs($this->user)->post('/security-handler/'.$this->user->id, [
            'email' => 'lesha24@mail.ru',
            'password' => 'qwerty1234',
            'password_confirmation' => 'qwerty1234',
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'email' => 'lesha24@mail.ru',
        ]);
        $response->assertStatus(302);
    }
    public function test_security_act_with_old_email()
    {
        $response = $this->actingAs($this->user)->post('/security-handler/'.$this->user->id, [
            'email' => $this->user->email,
            'password' => 'qwerty123456',
            'password_confirmation' => 'qwerty123456',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'email' => $this->user->email,
        ]);
        $response->assertRedirect('/');
    }
    public function test_security_act_with_existing_email_and_short_password()
    {
        $response = $this->actingAs($this->user)->post('/security-handler/'.$this->user->id, [
            'email' => $this->email_admin,
            'password' => 'qw',
            'password_confirmation' => 'qw',
        ]);
        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id,
            'email' => $this->email_admin,
        ]);
        $response->assertSessionHasErrors([
            'email' => 'Данный email уже существует.',
            'password' => 'Пароль должен быть от 5 до 10 символов.',
        ]);
        $response->assertStatus(302);
    }
    public function test_security_act_with_no_post_request()
    {
        $response = $this->post('/security-handler/'.$this->user->id);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

}