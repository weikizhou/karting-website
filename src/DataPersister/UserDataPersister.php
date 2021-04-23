<?php


namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister implements DataPersisterInterface
{
    private $entityManager;
    private $userPasswordEncoder;
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    public function supports($data): bool
    {
        return $data instanceof User;
    }
    /**
     * @param User $data
     */
    public function persist($data)
    {
        if ($data->getPassword()) {
            $data->setPassword(
                $this->userPasswordEncoder->encodePassword($data, $data->getPassword())
            );
            $data->eraseCredentials();
        }
        if ($data->getRepeatedPassword()) {
            $data->setRepeatedPassword(
                $this->userPasswordEncoder->encodePassword($data, $data->getRepeatedPassword())
            );
            $data->eraseCredentials();
        }
        if ($data->getOldPassword()) {
            $data->setOldPassword(
                $this->userPasswordEncoder->encodePassword($data, $data->getOldPassword())
            );
            $data->eraseCredentials();
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}