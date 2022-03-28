<?php

namespace App\MainBundle\Entity;

use App\MainBundle\Repository\DebtRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Debt
 *
 * @ORM\Table(name="debt", indexes={@ORM\Index(name="debt_account_id_fk", columns={"account_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=DebtRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Debt
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

    public function getLender(): ?string
    {
        return $this->lender;
    }

    public function setLender(?string $lender): self
    {
        $this->lender = $lender;

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

    public function getPay(): ?int
    {
        return $this->pay;
    }

    public function setPay(int $pay): self
    {
        $this->pay = $pay;

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

    public function getDueDate(): ?int
    {
        return $this->dueDate;
    }

    public function setDueDate(?int $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getLendDate(): ?int
    {
        return $this->lendDate;
    }

    public function setLendDate(?int $lendDate): self
    {
        $this->lendDate = $lendDate;

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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
     * @ORM\Column(name="lender", type="text", length=65535, nullable=true)
     */
    private $lender;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color", type="text", length=65535, nullable=true)
     */
    private $color;

    /**
     * @var int
     *
     * @ORM\Column(name="pay", type="integer", nullable=false)
     */
    private $pay;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="due_date", type="integer", nullable=true)
     */
    private $dueDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="lend_date", type="integer", nullable=true)
     */
    private $lendDate;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

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
