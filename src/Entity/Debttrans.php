<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Debttrans
 *
 * @ORM\Table(name="debtTrans", indexes={@ORM\Index(name="debtTrans_debt_id_fk", columns={"debt_id"})})
 * @ORM\Entity
 */
class Debttrans
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
    public function getDateTime(): ?int
    {
        return $this->dateTime;
    }

    /**
     * @param int|null $dateTime
     */
    public function setDateTime(?int $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     */
    public function setNote(?string $note): void
    {
        $this->note = $note;
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
     * @return \Debt
     */
    public function getDebt(): \Debt
    {
        return $this->debt;
    }

    /**
     * @param \Debt $debt
     */
    public function setDebt(\Debt $debt): void
    {
        $this->debt = $debt;
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
