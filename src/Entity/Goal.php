<?php

namespace App\Entity;

use App\Repository\GoalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Goal
 *
 * @ORM\Table(name="goal", indexes={@ORM\Index(name="goal_account_id_fk", columns={"account_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=GoalRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Goal
{

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSaved(): ?int
    {
        return $this->saved;
    }

    public function setSaved(int $saved): self
    {
        $this->saved = $saved;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getExpectDate(): ?int
    {
        return $this->expectDate;
    }

    public function setExpectDate(?int $expectDate): self
    {
        $this->expectDate = $expectDate;

        return $this;
    }

    public function getAchieveDate(): ?int
    {
        return $this->achieveDate;
    }

    public function setAchieveDate(?int $achieveDate): self
    {
        $this->achieveDate = $achieveDate;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
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
