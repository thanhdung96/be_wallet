<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trans
 *
 * @ORM\Table(name="trans", indexes={@ORM\Index(name="trans___fk_target_wallet", columns={"transfer_wallet_id"}), @ORM\Index(name="trans___fk_account", columns={"account_id"}), @ORM\Index(name="trans___fk_wallet", columns={"wallet_id"}), @ORM\Index(name="trans___fk_category", columns={"category_id"})})
 * @ORM\Entity
 */
class Trans
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
     * @ORM\Column(name="fee", type="integer", nullable=true)
     */
    private $fee;

    /**
     * @var int
     *
     * @ORM\Column(name="trans_amount", type="integer", nullable=false)
     */
    private $transAmount;

    /**
     * @var int
     *
     * @ORM\Column(name="debt_id", type="integer", nullable=false)
     */
    private $debtId;

    /**
     * @var int
     *
     * @ORM\Column(name="debt_trans_id", type="integer", nullable=false)
     */
    private $debtTransId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=false)
     */
    private $modified;

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
    public function getFee(): ?int
    {
        return $this->fee;
    }

    /**
     * @param int|null $fee
     */
    public function setFee(?int $fee): void
    {
        $this->fee = $fee;
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
    public function getDebtId(): int
    {
        return $this->debtId;
    }

    /**
     * @param int $debtId
     */
    public function setDebtId(int $debtId): void
    {
        $this->debtId = $debtId;
    }

    /**
     * @return int
     */
    public function getDebtTransId(): int
    {
        return $this->debtTransId;
    }

    /**
     * @param int $debtTransId
     */
    public function setDebtTransId(int $debtTransId): void
    {
        $this->debtTransId = $debtTransId;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime
    {
        return $this->modified;
    }

    /**
     * @param \DateTime $modified
     */
    public function setModified(\DateTime $modified): void
    {
        $this->modified = $modified;
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
