<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Currency
 *
 * @ORM\Table(name="currency", uniqueConstraints={@ORM\UniqueConstraint(name="currency_name_UNIQUE", columns={"currency_name"})})
 * @ORM\Entity
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

    /**
     * @return int
     */
    public function getId(): int
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

    /**
     * @return string
     */
    public function getCurrencyName(): string
    {
        return $this->currencyName;
    }

    /**
     * @param string $currencyName
     */
    public function setCurrencyName(string $currencyName): void
    {
        $this->currencyName = $currencyName;
    }

    /**
     * @return string|null
     */
    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    /**
     * @param string|null $symbol
     */
    public function setSymbol(?string $symbol): void
    {
        $this->symbol = $symbol;
    }

}
