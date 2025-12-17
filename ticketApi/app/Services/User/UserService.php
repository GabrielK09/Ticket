<?php

namespace App\Services\User;

use App\Repositories\Eloquent\UserEloquent\UserRepository;
use Exception;
use Hamcrest\StringDescription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserService 
{
    public function __construct(
        protected UserRepository $userRepository
    ){}

    public function store(array $data)
    {
        if($this->userRepository->findByMail($data['email']))
        {
            throw new Exception('Esse e-mail já está cadastrado!');
        }

        return DB::transaction(fn() => $this->userRepository->store($data));
    }

    public function update(array $data)
    {
        if(!$this->userRepository->findById($data['user_id']))
        {
            throw new Exception('Usuário não localizado!');
        }

        return DB::transaction(fn() => $this->userRepository->update($data));
    }
    
    public function findByMail(string $email)
    {
        return $this->userRepository->findByMail($email);
    }

    public function getUserForAuthOrFail(string $email) 
    {
        $user = $this->findByMail($email);

        if(!$user)
        {
            throw ValidationException::withMessages([
                'email' => ['Credenciais incorretas.'],
            ]);
        }

        return $user;
    }

    public function emailExists(string $email): bool 
    {
        return $this->findByMail($email) !== null;
    }

    public function findById(string $id)
    {
        $user = $this->userRepository->findById($id);

        if(!$user)
        {
            throw new Exception('Usuário não localizado!');
            
        }

        return $user;
    }
}