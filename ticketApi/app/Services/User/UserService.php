<?php

namespace App\Services\User;

use App\Repositories\Eloquent\UserEloquent\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $user = $this->userRepository->findByMail($email);

        if(!$user)
        {
            throw new Exception('Usuário não localizado!');
            
        }

        return $user;
    }

    public function findByMailForAuth(string $email)
    {
        $user = $this->userRepository->findByMail($email);

        if(!$user)
        {
            throw new Exception('Credencias incorretas!');
            
        }

        return $user;
    }

    public function checkExistEmail(string $email)
    {
        $user = $this->userRepository->findByMail($email);

        Log::channel('auth')->debug('In service ' . $user);

        if($user)
        {
            Log::channel('auth')->debug('Vai retornar ' . $user);
            return $user;   
        }

        return null;
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