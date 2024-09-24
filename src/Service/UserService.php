<?php

namespace App\Service;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function existsUserEmail($email): null{
        return $this->userRepository->findOneByEmail($email);
    }

    public function saveUser(User $user): void
    {
        $this->userRepository->add($user);
    }
}