<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ApiResource(
 *      itemOperations={
 *         "post"={
 *             "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *         },
 *          "get"={},
 *         "put"={
 *             "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *         },
  *         "delete"={
 *             "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *         },
 *      },
 *      collectionOperations={
 *         "post"={
 *             "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"
 *         },
 *          "get"={}
 *      }  
 * )
 */
class Category implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */    
    private $products;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modified_at;        


    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        $this->setModifiedAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     * 
     */

    public function getProducts(): Collection
    {
        return $this->products;
    }    

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    /**
    * @ORM\PreUpdate
    */    

    public function setModifiedAt(\DateTimeInterface $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }    
    public function jsonSerialize()
    {
        return [
            "id"=> $this->getId(),
            "name" => $this->getName()
        ];
    }

}
