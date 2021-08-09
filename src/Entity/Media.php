<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="media", indexes={@ORM\Index(name="media_trans_id_fk", columns={"trans_id"})})
 * @ORM\Entity
 */
class Media
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
     * @ORM\Column(name="path", type="text", length=65535, nullable=true)
     */
    private $path;

    /**
     * @var \Trans
     *
     * @ORM\ManyToOne(targetEntity="Trans")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trans_id", referencedColumnName="id")
     * })
     */
    private $trans;

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
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return \Trans
     */
    public function getTrans(): \Trans
    {
        return $this->trans;
    }

    /**
     * @param \Trans $trans
     */
    public function setTrans(\Trans $trans): void
    {
        $this->trans = $trans;
    }


}
