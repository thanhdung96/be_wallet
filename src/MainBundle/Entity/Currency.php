<?php

namespace App\MainBundle\Entity;

use App\MainBundle\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Currency
 *
 * @ORM\Table(name="currency", uniqueConstraints={@ORM\UniqueConstraint(name="currency_name_UNIQUE", columns={"currency_name"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Currency
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="currency_name", type="string", length=50, nullable=false)
     */
    private $currencyName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="symbol", type="string", length=5, nullable=true)
     */
    private $symbol;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currencyName;
    }

    public function setCurrencyName(string $currencyName): self
    {
        $this->currencyName = $currencyName;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

}
