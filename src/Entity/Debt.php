<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Debt
 *
 * @ORM\Table(name="debt", indexes={@ORM\Index(name="debt_account_id_fk", columns={"account_id"})})
 * @ORM\Entity
 */
class Debt
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
    public function getLender(): ?string
    {
        return $this->lender;
    }

    /**
     * @param string|null $lender
     */
    public function setLender(?string $lender): void
    {
        $this->lender = $lender;
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
    public function getPay(): int
    {
        return $this->pay;
    }

    /**
     * @param int $pay
     */
    public function setPay(int $pay): void
    {
        $this->pay = $pay;
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
     * @return int|null
     */
    public function getDueDate(): ?int
    {
        return $this->dueDate;
    }

    /**
     * @param int|null $dueDate
     */
    public function setDueDate(?int $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return int|null
     */
    public function getLendDate(): ?int
    {
        return $this->lendDate;
    }

    /**
     * @param int|null $lendDate
     */
    public function setLendDate(?int $lendDate): void
    {
        $this->lendDate = $lendDate;
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
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
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
