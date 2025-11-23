<?php

namespace App\Repositories\Eloquent\UserEloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository 
{
    public function store(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function findById(string $id)
    {
        return User::findOrFail($id);
    }

    public function findByMail(string $email)
    {
        return User::where('email', $email)->first();
    }
}