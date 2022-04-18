<?php

namespace App\MainBundle\Entity;

use App\MainBundle\Enums\SupportLanguages;
use App\MainBundle\Repository\AccountSettingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountSettingRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class AccountSetting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="dark_mode", type="boolean", nullable=false)
     */
    private $darkMode;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=10, nullable=false)
     */
    private $language;

    /**
     * @var \Account
     * 
     * @ORM\OneToOne(targetEntity="Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;

     /**
     * @var \Currency
     *
     * @ORM\ManyToOne(targetEntity="Currency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     */
    private $currency;

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

    public function __construct()
    {
        $currentDateTime = new \DateTime();
        $this->id = -1;
        $this->created = $currentDateTime;
        $this->modified = $currentDateTime;
        $this->darkMode = true;
        $this->language = SupportLanguages::ENGLISH;
        $this->currency = new Currency();
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateTimestamp()
    {
        $currentTimestamp = new \DateTime();

        $this->modified = $currentTimestamp;

        if (is_null($this->created)) {
            $this->created = $currentTimestamp;
        }
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of darkMode
     *
     * @return  bool
     */
    public function getDarkMode()
    {
        return $this->darkMode;
    }

    /**
     * Set the value of darkMode
     *
     * @param  bool  $darkMode
     *
     * @return  self
     */
    public function setDarkMode(bool $darkMode)
    {
        $this->darkMode = $darkMode;

        return $this;
    }

    /**
     * Get the value of language
     *
     * @return  string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set the value of language
     *
     * @param  string  $language
     *
     * @return  self
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get the value of created
     *
     * @return  \DateTime
     */ 
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the value of created
     *
     * @param  \DateTime  $created
     *
     * @return  self
     */ 
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get the value of modified
     *
     * @return  \DateTime
     */ 
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set the value of modified
     *
     * @param  \DateTime  $modified
     *
     * @return  self
     */ 
    public function setModified(\DateTime $modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get the value of account
     *
     * @return  \Account
     */ 
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set the value of account
     *
     * @param  \Account  $account
     *
     * @return  self
     */ 
    public function setAccount(?Account $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return \Currency
     */
    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    /**
     * @param \Currency $currency
     */
    public function setCurrency(?Currency $currency): void
    {
        $this->currency = $currency;
    }
}
