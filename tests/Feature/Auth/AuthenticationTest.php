<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $this->get('/login')->assertOk();
});

test('users can authenticate with correct credentials', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('dashboard'));
});

test('users cannot authenticate with a wrong password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('the session id changes on login to prevent session fixation', function () {
    $user = User::factory()->create();

    $this->get('/login');
    $before = session()->getId();

    $this->post('/login', ['email' => $user->email, 'password' => 'password']);

    expect(session()->getId())->not->toBe($before);
});

test('login is throttled after five failed attempts', function () {
    $user = User::factory()->create();

    foreach (range(1, 5) as $ignored) {
        $this->post('/login', ['email' => $user->email, 'password' => 'wrong-password']);
    }

    // The 6th attempt is blocked even though the password is now correct.
    $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

    $response->assertSessionHasErrors('email');
    expect(session('errors')->first('email'))->toContain('Too many login attempts');
    $this->assertGuest();
});

test('guests are redirected to login when visiting the dashboard', function () {
    $this->get('/dashboard')->assertRedirect(route('login'));
});

test('authenticated users can view the dashboard', function () {
    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertOk();
});

test('users can log out', function () {
    $this->actingAs(User::factory()->create())
        ->post('/logout')
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('logout is not reachable over GET', function () {
    // 405 Method Not Allowed: a stray <img src="/logout"> on another site
    // cannot log the user out.
    $this->actingAs(User::factory()->create())
        ->get('/logout')
        ->assertMethodNotAllowed();

    $this->assertAuthenticated();
});
