<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="id_product", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $product;


    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="author", type="string", length=100)
     */
    private $author;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createAt", type="datetime")
     */
    private $createAt;

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Range(
     *     min=0,
     *     max=5,
     *     minMessage = "Le score doit être de {{ limit }} minimum",
     *     maxMessage = "Le score est {{ limit }} au maximum."
     * )
     *
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;


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
     * Set author
     *
     * @param string $author
     *
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Comment
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Comment
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set product
     *
     * @param \adminBundle\Entity\Product $product
     *
     * @return Comment
     */
    public function setProduct(\adminBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \adminBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
