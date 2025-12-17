<?php

namespace App\Repositories\Eloquent\UserEloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository 
{
    public function store(array $data): ?User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function update(array $data): ?User
    {
        $user = $this->findById($data['user_id']);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return $user;
    }

    public function findById(string $id): ?User
    {
        return User::findOrFail($id);
    }

    public function findByMail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }
}