<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client //implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @ORM\Column(type="string", length=255, name="company_name")
     */
    private $companyName = '';
    /**
     * @ORM\Column(type="string", length=16)
     */
    private $inn = '';
    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $address = '';
    /**
     * @ORM\Column(type="string", length=256)
     */
    private $email = '';
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $tel = '';
    
    
    /**
     * Client constructor.
     * @param $userid
     * @param $companyName
     * @param $inn
     * @param $address
     * @param $email
     * @param $tel
     */
    public function __construct($companyName, $inn, $address, $email, $tel)
    {
        $this->setCompanyName($companyName);
        $this->setInn($inn);
        $this->setAddress($address);
        $this->setEmail($email);
        $this->setTel($tel);
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }
    
    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }
    
    /**
     * @param string $inn
     */
    public function setInn($inn)
    {
        $this->inn = $inn;
    }
    
    /**
     * @return string
     */
    public function getInn()
    {
        return $this->inn;
    }
    
    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
    
    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }
    
    /**
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }
    
    /**
     * @param User $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
        $this->userId = $user->getId();
    }
    
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }


    /*
    public static function fromArray($array)
    {
        $client = new Client(
            0,
            $array['company_name'],
            $array['inn'],
            $array['address'],
            $array['email'],
            $array['tel'],
            $array['username']
        );
        return $client;
    }
    
    */
    /**
     * To json_serialize private fields
     * @return array
     */
    /*
    public function jsonSerialize()
    {
        $parent = $this->user->jsonSerialize();
        $vars = [
            'companyName' => $this->getCompanyName(),
            'inn' => $this->getInn(),
            'address' => $this->getAddress(),
            'email' => $this->getEmail(),
            'tel' => $this->getTel()
        ];
        
        return array_merge($parent, $vars);
    }
    */
}