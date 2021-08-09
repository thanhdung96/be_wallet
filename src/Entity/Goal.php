<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Goal
 *
 * @ORM\Table(name="goal", indexes={@ORM\Index(name="goal_account_id_fk", columns={"account_id"})})
 * @ORM\Entity
 */
class Goal
{
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     */
    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return int
     */
    public function getSaved(): int
    {
        return $this->saved;
    }

    /**
     * @param int $saved
     */
    public function setSaved(int $saved): void
    {
        $this->saved = $saved;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getExpectDate(): ?int
    {
        return $this->expectDate;
    }

    /**
     * @param int|null $expectDate
     */
    public function setExpectDate(?int $expectDate): void
    {
        $this->expectDate = $expectDate;
    }

    /**
     * @return int|null
     */
    public function getAchieveDate(): ?int
    {
        return $this->achieveDate;
    }

    /**
     * @param int|null $achieveDate
     */
    public function setAchieveDate(?int $achieveDate): void
    {
        $this->achieveDate = $achieveDate;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return \Account
     */
    public function getAccount(): \Account
    {
        return $this->account;
    }

    /**
     * @param \Account $account
     */
    public function setAccount(\Account $account): void
    {
        $this->account = $account;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="text", length=65535, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color", type="text", length=65535, nullable=true)
     */
    private $color;

    /**
     * @var int
     *
     * @ORM\Column(name="saved", type="integer", nullable=false)
     */
    private $saved;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var int|null
     *
     * @ORM\Column(name="expect_date", type="integer", nullable=true)
     */
    private $expectDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="achieve_date", type="integer", nullable=true)
     */
    private $achieveDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="currency", type="text", length=65535, nullable=true)
     */
    private $currency;

    /**
     * @var \Account
     *
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;


}
