<?php

namespace App\MainBundle\Entity;

use App\MainBundle\Repository\DebttransRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Debttrans
 *
 * @ORM\Table(name="debtTrans", indexes={@ORM\Index(name="debtTrans_debt_id_fk", columns={"debt_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=DebttransRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Debttrans
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDateTime(): ?int
    {
        return $this->dateTime;
    }

    public function setDateTime(?int $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

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

    public function getDebt(): ?Debt
    {
        return $this->debt;
    }

    public function setDebt(?Debt $debt): self
    {
        $this->debt = $debt;

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
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="date_time", type="integer", nullable=true)
     */
    private $dateTime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="text", length=65535, nullable=true)
     */
    private $note;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var \Debt
     *
     * @ORM\ManyToOne(targetEntity="Debt")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="debt_id", referencedColumnName="id")
     * })
     */
    private $debt;


}
