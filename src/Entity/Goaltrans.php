<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Goaltrans
 *
 * @ORM\Table(name="goalTrans", indexes={@ORM\Index(name="goalTrans_goal_id_fk", columns={"goal_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=GoaltransRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Goaltrans
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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

    public function getGoal(): ?Goal
    {
        return $this->goal;
    }

    public function setGoal(?Goal $goal): self
    {
        $this->goal = $goal;

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
