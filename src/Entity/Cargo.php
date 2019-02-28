<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;
use Zend\EventManager\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CargoRepository")
 */
class Cargo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min = 3, max = 50)
     */
    private $container;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotBlank
     */
    private $dateArrival;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    public static $availableStatus = ['on_board', 'finished'];
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     */
    private $client;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manager", inversedBy="cargoes")
     */
    private $manager;

    public function __construct($container, $dateArrival, $client, $status = null)
    {
        $this->setContainer($container);
        $this->setClient($client);
        $this->setDateArrival($dateArrival);
        $this->setStatus(is_null($status) ? self::$availableStatus[0] : $status);
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContainer(): ?string
    {
        return $this->container;
    }

    public function setContainer(?string $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function getDateArrival(): ?\DateTimeInterface
    {
        return $this->dateArrival;
    }

    public function setDateArrival($dateArrival): self
    {
        if (is_string($dateArrival)) {
            $this->dateArrival = new \DateTime($dateArrival, new \DateTimeZone('Europe/Moscow'));
        } elseif ($dateArrival instanceof \DateTimeInterface) {
            $this->dateArrival = $dateArrival;
        } else {
            throw new \Symfony\Component\Form\Exception\InvalidArgumentException('Дата в неправильном формате');
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (in_array($status, self::$availableStatus)) {
            $this->status = $status;
        } else {
            throw new InvalidArgumentException("Данный статус груза не разрешён: $status");
        }
        

        return $this;
    }
    

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
    
    public function getManager(): ?Manager
    {
        return $this->manager;
    }
    
    public function setManager(?Manager $manager): self
    {
        $this->manager = $manager;
        
        return $this;
    }
    
    public function isOwned(User $user)
    {
        $result = false;
        $manager = $this->getManager();
        if (!is_null($manager)) {
            $result = $manager->getUser()->getId() === $user->getId();
        }
        return $result;
    }
}
