<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recurring
 *
 * @ORM\Table(name="recurring", indexes={@ORM\Index(name="recurring___fk_account", columns={"account_id"}), @ORM\Index(name="recurring___fk_transfer_wallet", columns={"transfer_wallet_id"}), @ORM\Index(name="recurring___fk_category", columns={"category_id"}), @ORM\Index(name="recurring___fk_wallet", columns={"wallet_id"})})
 * @ORM\Entity
 */
class Recurring
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
     * @ORM\Column(name="note", type="text", length=65535, nullable=true)
     */
    private $note;

    /**
     * @var string|null
     *
     * @ORM\Column(name="memo", type="text", length=65535, nullable=true)
     */
    private $memo;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="recurring_type", type="integer", nullable=false)
     */
    private $recurringType;

    /**
     * @var int
     *
     * @ORM\Column(name="repeat_type", type="integer", nullable=false)
     */
    private $repeatType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="repeat_date", type="text", length=65535, nullable=true)
     */
    private $repeatDate;

    /**
     * @var int
     *
     * @ORM\Column(name="increment", type="integer", nullable=false)
     */
    private $increment;

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
     * @var int|null
     *
     * @ORM\Column(name="until_time", type="integer", nullable=true)
     */
    private $untilTime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="last_update_time", type="integer", nullable=true)
     */
    private $lastUpdateTime;

    /**
     * @var int
     *
     * @ORM\Column(name="trans_amount", type="integer", nullable=false)
     */
    private $transAmount;

    /**
     * @var int
     *
     * @ORM\Column(name="is_future", type="integer", nullable=false)
     */
    private $isFuture;

    /**
     * @var \Account
     *
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Wallet
     *
     * @ORM\ManyToOne(targetEntity="Wallet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transfer_wallet_id", referencedColumnName="id")
     * })
     */
    private $transferWallet;

    /**
     * @var \Wallet
     *
     * @ORM\ManyToOne(targetEntity="Wallet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="wallet_id", referencedColumnName="id")
     * })
     */
    private $wallet;

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
     * @return string|null
     */
    public function getMemo(): ?string
    {
        return $this->memo;
    }

    /**
     * @param string|null $memo
     */
    public function setMemo(?string $memo): void
    {
        $this->memo = $memo;
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
     * @return int
     */
    public function getRecurringType(): int
    {
        return $this->recurringType;
    }

    /**
     * @param int $recurringType
     */
    public function setRecurringType(int $recurringType): void
    {
        $this->recurringType = $recurringType;
    }

    /**
     * @return int
     */
    public function getRepeatType(): int
    {
        return $this->repeatType;
    }

    /**
     * @param int $repeatType
     */
    public function setRepeatType(int $repeatType): void
    {
        $this->repeatType = $repeatType;
    }

    /**
     * @return string|null
     */
    public function getRepeatDate(): ?string
    {
        return $this->repeatDate;
    }

    /**
     * @param string|null $repeatDate
     */
    public function setRepeatDate(?string $repeatDate): void
    {
        $this->repeatDate = $repeatDate;
    }

    /**
     * @return int
     */
    public function getIncrement(): int
    {
        return $this->increment;
    }

    /**
     * @param int $increment
     */
    public function setIncrement(int $increment): void
    {
        $this->increment = $increment;
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
     * @return int|null
     */
    public function getUntilTime(): ?int
    {
        return $this->untilTime;
    }

    /**
     * @param int|null $untilTime
     */
    public function setUntilTime(?int $untilTime): void
    {
        $this->untilTime = $untilTime;
    }

    /**
     * @return int|null
     */
    public function getLastUpdateTime(): ?int
    {
        return $this->lastUpdateTime;
    }

    /**
     * @param int|null $lastUpdateTime
     */
    public function setLastUpdateTime(?int $lastUpdateTime): void
    {
        $this->lastUpdateTime = $lastUpdateTime;
    }

    /**
     * @return int
     */
    public function getTransAmount(): int
    {
        return $this->transAmount;
    }

    /**
     * @param int $transAmount
     */
    public function setTransAmount(int $transAmount): void
    {
        $this->transAmount = $transAmount;
    }

    /**
     * @return int
     */
    public function getIsFuture(): int
    {
        return $this->isFuture;
    }

    /**
     * @param int $isFuture
     */
    public function setIsFuture(int $isFuture): void
    {
        $this->isFuture = $isFuture;
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
     * @return \Category
     */
    public function getCategory(): \Category
    {
        return $this->category;
    }

    /**
     * @param \Category $category
     */
    public function setCategory(\Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return \Wallet
     */
    public function getTransferWallet(): \Wallet
    {
        return $this->transferWallet;
    }

    /**
     * @param \Wallet $transferWallet
     */
    public function setTransferWallet(\Wallet $transferWallet): void
    {
        $this->transferWallet = $transferWallet;
    }

    /**
     * @return \Wallet
     */
    public function getWallet(): \Wallet
    {
        return $this->wallet;
    }

    /**
     * @param \Wallet $wallet
     */
    public function setWallet(\Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }


}
