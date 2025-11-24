<?php

namespace App\Services\User;

use App\Repositories\Eloquent\UserEloquent\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;

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
    
    public function findByMail(string $email)
    {
        $user = $this->userRepository->findByMail($email);

        if(!$user)
        {
            throw new Exception('Usuário não localizado');
            
        }

        return $user;
    }
}