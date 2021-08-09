<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Goaltrans
 *
 * @ORM\Table(name="goalTrans", indexes={@ORM\Index(name="goalTrans_goal_id_fk", columns={"goal_id"})})
 * @ORM\Entity
 */
class Goaltrans
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
     * @return \Goal
     */
    public function getGoal(): \Goal
    {
        return $this->goal;
    }

    /**
     * @param \Goal $goal
     */
    public function setGoal(\Goal $goal): void
    {
        $this->goal = $goal;
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
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="text", length=65535, nullable=true)
     */
    private $note;

    /**
     * @var \Goal
     *
     * @ORM\ManyToOne(targetEntity="Goal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="goal_id", referencedColumnName="id")
     * })
     */
    private $goal;


}
