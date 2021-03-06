<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="categorie")
     * @ORM\JoinColumn(name="id_product", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $product;

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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true, unique=true)
     *
     * @Assert\NotBlank(
     *     message="Veuillez remplir ce champ"
     * )
     * @Assert\Length(
     *      min=2,
     *      minMessage="Votre titre doit contenir au minimum {{ limit }} caractères"
     *  )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max=300,
     *      maxMessage="Votre descritpion doit contenir au maximum {{ limit }} caractères"
     *  )
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     *
     * @Assert\NotBlank()
     *
     */
    private $position;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     *
     * @Assert\NotBlank()
     *
     */
    private $active;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Categorie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Categorie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Categorie
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload){
        //die(dump($this->getPosition()));

        if ($this->getPosition() == 0 && $this->getTitle() != "Par défaut"){
            $context->buildViolation('La position "0" est réservé à la catégorie "par défaut"')
                // permet d'attacher l'erreur à une propriété
                //->atPath('position')
                ->addViolation();
        }
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Categorie
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \adminBundle\Entity\Product $product
     *
     * @return Categorie
     */
    public function addProduct(\adminBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \adminBundle\Entity\Product $product
     */
    public function removeProduct(\adminBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product;
    }
}
