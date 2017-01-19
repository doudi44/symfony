<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\ProductRepository")
 * @ORM\EntityListeners({"adminBundle\Listener\ProductListener"})
 */
class Product
{
    /**
     * @ORM\ManyToOne(targetEntity="Marque")
     * @ORM\JoinColumn(name="id_marque", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $marque;

    /**
     * @ORM\ManyToMany(targetEntity="Categorie", inversedBy="product")
     * @ORM\JoinColumn(name="id_categorie", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $categorie;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     *
     */
    private $id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     *
     *
     */
    private $dateCreation;

    /**
     * @var datetime
     *
     * @ORM\Column(name="dateModif", type="datetime")
     *
     *
     */
    private $dateModif;


    /**
     * @var string
     *
     * @ORM\Column(name="titleFR", type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min=2,
     *      minMessage="Votre titre doit contenir au moins {{ limit }} caractères"
     *  )

     */
    private $titleFR;

    /**
     * @var string
     *
     * @ORM\Column(name="titleEN", type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min=2,
     *      minMessage="Votre titre doit contenir au moins {{ limit }} caractères"
     *  )

     */
    private $titleEN;


    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100)
     *
     */
    private $image;


    /**
     * @var string
     *
     * @ORM\Column(name="descriptionFR", type="text", nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max=300,
     *      maxMessage="Votre descritpion doit contenir au maximum {{ limit }} caractères"
     *  )
     */
    private $descriptionFR;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionEN", type="text", nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max=300,
     *      maxMessage="Votre descritpion doit contenir au maximum {{ limit }} caractères"
     *  )
     */
    private $descriptionEN;


    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min=0.01,
     *      minMessage="Votre prix doit être suppérieur à 0"
     *  )
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotBlank()
     */
    private $quantity;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categorie = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categorie
     *
     * @param \adminBundle\Entity\Categorie $categorie
     *
     * @return Product
     */
    public function addCategorie(\adminBundle\Entity\Categorie $categorie)
    {
        $this->categorie[] = $categorie;

        return $this;
    }

    /**
     * Remove categorie
     *
     * @param \adminBundle\Entity\Categorie $categorie
     */
    public function removeCategorie(\adminBundle\Entity\Categorie $categorie)
    {
        $this->categorie->removeElement($categorie);
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Product
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     *
     * @return Product
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    /**
     * Get dateModif
     *
     * @return \DateTime
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * Set titleFR
     *
     * @param string $titleFR
     *
     * @return Product
     */
    public function setTitleFR($titleFR)
    {
        $this->titleFR = $titleFR;

        return $this;
    }

    /**
     * Get titleFR
     *
     * @return string
     */
    public function getTitleFR()
    {
        return $this->titleFR;
    }

    /**
     * Set titleEN
     *
     * @param string $titleEN
     *
     * @return Product
     */
    public function setTitleEN($titleEN)
    {
        $this->titleEN = $titleEN;

        return $this;
    }

    /**
     * Get titleEN
     *
     * @return string
     */
    public function getTitleEN()
    {
        return $this->titleEN;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set descriptionFR
     *
     * @param string $descriptionFR
     *
     * @return Product
     */
    public function setDescriptionFR($descriptionFR)
    {
        $this->descriptionFR = $descriptionFR;

        return $this;
    }

    /**
     * Get descriptionFR
     *
     * @return string
     */
    public function getDescriptionFR()
    {
        return $this->descriptionFR;
    }

    /**
     * Set descriptionEN
     *
     * @param string $descriptionEN
     *
     * @return Product
     */
    public function setDescriptionEN($descriptionEN)
    {
        $this->descriptionEN = $descriptionEN;

        return $this;
    }

    /**
     * Get descriptionEN
     *
     * @return string
     */
    public function getDescriptionEN()
    {
        return $this->descriptionEN;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set marque
     *
     * @param \adminBundle\Entity\Marque $marque
     *
     * @return Product
     */
    public function setMarque(\adminBundle\Entity\Marque $marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \adminBundle\Entity\Marque
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Get categorie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
