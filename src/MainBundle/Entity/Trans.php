<?php

namespace App\MainBundle\Entity;

use App\MainBundle\Enums\TransferTypes;
use App\MainBundle\Repository\TransRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trans
 *
 * @ORM\Table(name="trans", indexes={@ORM\Index(name="trans___fk_target_wallet", columns={"transfer_wallet_id"}), @ORM\Index(name="trans___fk_account", columns={"account_id"}), @ORM\Index(name="trans___fk_wallet", columns={"wallet_id"}), @ORM\Index(name="trans___fk_category", columns={"category_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=TransRepository::class)
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(name="note", type="string", length=2048, nullable=true)
     */
    private $note;

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
    private $amount = 0;

    /**
     * @var int|null
     *
     * @ORM\Column(name="date_time", type="datetime", nullable=true)
     */
    private $dateTime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fee", type="integer", nullable=true)
     */
    private $fee = 0;

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getFee(): ?int
    {
        return $this->fee;
    }

    public function setFee(?int $fee): self
    {
        $this->fee = $fee;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

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

    public function __construct() {
        $currentTimestamp = new \DateTime();

        $this->created = $currentTimestamp;
        $this->modified = $currentTimestamp;
        $this->type = TransferTypes::EXPENSE;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateTimestamp(){
        $currentTimestamp = new \DateTime();

        $this->modified = $currentTimestamp;

        if(is_null($this->getCreated())){
            $this->setCreated($currentTimestamp);
        }
    }

}
