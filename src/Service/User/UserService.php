<?php

namespace App\Service\User;
use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function existsUserEmail($email): ?User{
        return $this->userRepository->findOneByEmail($email);
    }

    public function saveUser(User $user): void
    {
        $this->userRepository->add($user);
    }

    public function findToken($token): ?User{
       return $this->userRepository->findOneByToken($token);
    }

    public function isTokenValid(User $user): bool{
       return $this->userRepository->tokenIsValid($user);
    }

    public function activateUser(User $user): void{
      $this->userRepository->updateUser($user);
    }
}