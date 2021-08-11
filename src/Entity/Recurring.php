<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recurring
 *
 * @ORM\Table(name="recurring", indexes={@ORM\Index(name="recurring___fk_account", columns={"account_id"}), @ORM\Index(name="recurring___fk_transfer_wallet", columns={"transfer_wallet_id"}), @ORM\Index(name="recurring___fk_category", columns={"category_id"}), @ORM\Index(name="recurring___fk_wallet", columns={"wallet_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=RecurringRepository::class)
 * @ORM\HasLifecycleCallbacks()
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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getMemo(): ?string
    {
        return $this->memo;
    }

    public function setMemo(?string $memo): self
    {
        $this->memo = $memo;

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

    public function getRecurringType(): ?int
    {
        return $this->recurringType;
    }

    public function setRecurringType(int $recurringType): self
    {
        $this->recurringType = $recurringType;

        return $this;
    }

    public function getRepeatType(): ?int
    {
        return $this->repeatType;
    }

    public function setRepeatType(int $repeatType): self
    {
        $this->repeatType = $repeatType;

        return $this;
    }

    public function getRepeatDate(): ?string
    {
        return $this->repeatDate;
    }

    public function setRepeatDate(?string $repeatDate): self
    {
        $this->repeatDate = $repeatDate;

        return $this;
    }

    public function getIncrement(): ?int
    {
        return $this->increment;
    }

    public function setIncrement(int $increment): self
    {
        $this->increment = $increment;

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

    public function getDateTime(): ?int
    {
        return $this->dateTime;
    }

    public function setDateTime(?int $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getUntilTime(): ?int
    {
        return $this->untilTime;
    }

    public function setUntilTime(?int $untilTime): self
    {
        $this->untilTime = $untilTime;

        return $this;
    }

    public function getLastUpdateTime(): ?int
    {
        return $this->lastUpdateTime;
    }

    public function setLastUpdateTime(?int $lastUpdateTime): self
    {
        $this->lastUpdateTime = $lastUpdateTime;

        return $this;
    }

    public function getTransAmount(): ?int
    {
        return $this->transAmount;
    }

    public function setTransAmount(int $transAmount): self
    {
        $this->transAmount = $transAmount;

        return $this;
    }

    public function getIsFuture(): ?int
    {
        return $this->isFuture;
    }

    public function setIsFuture(int $isFuture): self
    {
        $this->isFuture = $isFuture;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTransferWallet(): ?Wallet
    {
        return $this->transferWallet;
    }

    public function setTransferWallet(?Wallet $transferWallet): self
    {
        $this->transferWallet = $transferWallet;

        return $this;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(?Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }


}
