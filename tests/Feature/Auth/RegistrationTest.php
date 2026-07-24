<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $this->get('/register')->assertOk();
});

test('new users can register and are logged in', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard'));
});

test('password is stored hashed, never in plain text', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $user = User::where('email', 'test@example.com')->firstOrFail();

    expect($user->password)->not->toBe('password123')
        ->and(password_verify('password123', $user->password))->toBeTrue();
});

test('registration requires a matching password confirmation', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'something-else',
    ])->assertSessionHasErrors('password');

    $this->assertGuest();
});

test('email must be unique', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'taken@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('authenticated users cannot see the register form', function () {
    $this->actingAs(User::factory()->create())
        ->get('/register')
        ->assertRedirect(route('dashboard'));
});
