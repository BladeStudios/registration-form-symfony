<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ORM\Table(name="clients")
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2,max=255, minMessage="Imię i nazwisko lub nazwa firmy powinny zawierać od 2 do 255 znaków.", maxMessage="Imię i nazwisko lub nazwa firmy powinny zawierać od 2 do 255 znaków.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2,max=255, minMessage="Nazwa ulicy powinna zawierać od 2 do 255 znaków.", maxMessage="Nazwa ulicy powinna zawierać od 2 do 255 znaków.")
     */
    private $street_name;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(min=1,max=30, minMessage="Numer domu powinien zawierać od 1 do 30 znaków.", maxMessage="Numer domu powinien zawierać od 1 do 30 znaków.")
     */
    private $street_number;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2,max=255, minMessage="Nazwa miejscowości powinna zawierać od 2 do 255 znaków.", maxMessage="Nazwa miejscowości powinna zawierać od 2 do 255 znaków.")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\Length(min=6,max=6, exactMessage="Kod pocztowy powinien zawierać dokładnie {{ limit }} znaków.")
     * @Assert\Regex(pattern="/^[0-9]{2}-[0-9]{3}/", message="Niewłaściwy format kodu pocztowego.")
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Nie wybrano województwa.")
     * @Assert\Length(min=2,max=100, minMessage="Nazwa województwa powinna zawierać od 2 do 100 znaków.", maxMessage="Nazwa województwa powinna zawierać od 2 do 100 znaków.")
     */
    private $voivodeship;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(min=5,max=15, minMessage="Numer telefonu powinien zawierać od 5 do 15 cyfr.", maxMessage="Numer telefonu powinien zawierać od 5 do 15 cyfr.")
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Numer telefonu nie może zawierać innych znaków niż cyfry.")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Nie podano adresu e-mail.")
     * @Assert\Email(message="Nieprawidłowy adres e-mail.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $pesel;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $nip;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull(message="Nie wybrano rodzaju statusu prawnego.")
     */
    private $is_individual_client;

    /**
     * @ORM\Column(type="string", length=16)
     * @Assert\Length(min=2,max=8, minMessage="Numer kierunkowy powinien zawierać od 2 do 8 cyfr.", maxMessage="Numer kierunkowy powinien zawierać od 2 do 8 cyfr.")
     * @Assert\Regex(pattern="/^\+[0-9]+/", message="Numer kierunkowy powinien zawierać znak +, a następnie same cyfry.")
     */
    private $area_code;

    /**
     * @Assert\Callback
     */
    public function nipAndPeselValidation(ExecutionContextInterface $context)
    {
        $nip = $this->getNip();
        $pesel = $this->getPesel();
        $is_individual_client = $this->isIsIndividualClient();
        if(is_null($is_individual_client) || $is_individual_client===true)
        {
            if(empty($pesel))
                $context->buildViolation('Nie podano numeru PESEL.')
                ->atPath('pesel')
                ->addViolation();
            else
            {
                $reg = '/^[0-9]{11}$/';
                if(preg_match($reg, $pesel)==false)
                    $context->buildViolation('PESEL musi składać się z 11 cyfr.')
                    ->atPath('pesel')
                    ->addViolation();
                else
                {
                    $digits = str_split($pesel);
                    $checksum = (1*intval($digits[0]) + 3*intval($digits[1]) + 7*intval($digits[2]) + 9*intval($digits[3]) + 1*intval($digits[4]) + 3*intval($digits[5]) + 7*intval($digits[6]) + 9*intval($digits[7]) + 1*intval($digits[8]) + 3*intval($digits[9]))%10;
                    if($checksum == 0) 
                        $checksum = 10;
                    $checksum = 10 - $checksum;

                    if ((intval(substr($pesel, 4, 2)) > 31) ||
                    (intval(substr($pesel, 2, 2)) > 12) || 
                    !(intval($digits[10]) == $checksum))
                        $context->buildViolation('Niepoprawny PESEL.')
                        ->atPath('pesel')
                        ->addViolation();
                }
            }
        }
        else
        {
            if(empty($nip))
                $context->buildViolation('Nie podano numeru NIP.')
                ->atPath('nip')
                ->addViolation();
            else
            {
                $reg1 = '/^[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/';
                $reg2 = '/^[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{3}$/';
                $reg3 = '/^[0-9]{10}$/';
                if(preg_match($reg1, $nip)==false &&
                preg_match($reg2, $nip)==false &&
                preg_match($reg3, $nip)==false)
                    $context->buildViolation('Nieprawidłowy format. NIP powinien składać się z 10 cyfr, w formacie XXX-XXX-XX-XX, XXX-XX-XX-XXX lub XXXXXXXXXX.')
                    ->atPath('nip')
                    ->addViolation();
                else
                {
                    $nipWithoutDashes = preg_replace("/-/","",$nip);
                    $digits = str_split($nipWithoutDashes);
                    $checksum = (6*intval($digits[0]) + 5*intval($digits[1]) + 7*intval($digits[2]) + 2*intval($digits[3]) + 3*intval($digits[4]) + 4*intval($digits[5]) + 5*intval($digits[6]) + 6*intval($digits[7]) + 7*intval($digits[8]))%11;
            
                    if(!(intval($digits[9]) == $checksum))
                        $context->buildViolation('Niepoprawny NIP.')
                        ->atPath('nip')
                        ->addViolation();
                }
            }
        }

            
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->street_name;
    }

    public function setStreetName(string $street_name): self
    {
        $this->street_name = $street_name;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->street_number;
    }

    public function setStreetNumber(string $street_number): self
    {
        $this->street_number = $street_number;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getVoivodeship(): ?string
    {
        return $this->voivodeship;
    }

    public function setVoivodeship(string $voivodeship): self
    {
        $this->voivodeship = $voivodeship;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(?string $pesel): self
    {
        $this->pesel = $pesel;

        return $this;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(?string $nip): self
    {
        $this->nip = $nip;

        return $this;
    }

    public function isIsIndividualClient(): ?bool
    {
        return $this->is_individual_client;
    }

    public function setIsIndividualClient(bool $is_individual_client): self
    {
        $this->is_individual_client = $is_individual_client;

        return $this;
    }

    public function getAreaCode(): ?string
    {
        return $this->area_code;
    }

    public function setAreaCode(string $area_code): self
    {
        $this->area_code = $area_code;

        return $this;
    }
}
