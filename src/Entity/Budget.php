<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Budget
 *
 * @ORM\Table(name="budget")
 * @ORM\Entity
 */
class Budget
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
     * @var string|null
     *
     * @ORM\Column(name="name", type="text", length=65535, nullable=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="spent", type="integer", nullable=false)
     */
    private $spent;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="period_day", type="integer", nullable=false)
     */
    private $periodDay;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color", type="text", length=65535, nullable=true)
     */
    private $color;

    /**
     * @var int
     *
     * @ORM\Column(name="repeat", type="integer", nullable=false)
     */
    private $repeat;

    /**
     * @var int
     *
     * @ORM\Column(name="account_id", type="integer", nullable=false)
     */
    private $accountId;

    /**
     * @var int
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     */
    private $categoryId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="start_date", type="integer", nullable=true)
     */
    private $startDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="end_date", type="integer", nullable=true)
     */
    private $endDate;

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
    public function getSpent(): int
    {
        return $this->spent;
    }

    /**
     * @param int $spent
     */
    public function setSpent(int $spent): void
    {
        $this->spent = $spent;
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
    public function getPeriodDay(): int
    {
        return $this->periodDay;
    }

    /**
     * @param int $periodDay
     */
    public function setPeriodDay(int $periodDay): void
    {
        $this->periodDay = $periodDay;
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
    public function getRepeat(): int
    {
        return $this->repeat;
    }

    /**
     * @param int $repeat
     */
    public function setRepeat(int $repeat): void
    {
        $this->repeat = $repeat;
    }

    /**
     * @return int
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }

    /**
     * @param int $accountId
     */
    public function setAccountId(int $accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int|null
     */
    public function getStartDate(): ?int
    {
        return $this->startDate;
    }

    /**
     * @param int|null $startDate
     */
    public function setStartDate(?int $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return int|null
     */
    public function getEndDate(): ?int
    {
        return $this->endDate;
    }

    /**
     * @param int|null $endDate
     */
    public function setEndDate(?int $endDate): void
    {
        $this->endDate = $endDate;
    }


}
