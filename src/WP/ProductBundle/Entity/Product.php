<?php

namespace WP\ProductBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="WP\ProductBundle\Repository\ProductRepository")
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks()
 */
class Product implements ProductInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $sku;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * Current active price
     * if special price is set - equals special price, otherwise equals base price
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $basePrice;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $specialPrice;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade="all")
     * @ORM\JoinColumn(name="cover_id", referencedColumnName="id", nullable=true)
     */
    private $cover;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="WP\CategoryBundle\Entity\Category", inversedBy="products")
     * @ORM\JoinTable(name="category_product")
     **/
    private $categories;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    /**
     * @ORM\OneToMany(targetEntity="Product2Media", mappedBy="product", cascade="all", orphanRemoval=true)
     * @ORM\OrderBy({"pos" = "ASC"})
     */
    private $images;

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    /**
     * Return current active price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
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
     * Set title
     *
     * @param string $title
     *
     * @return Product
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
     * Set sku
     *
     * @param string $sku
     *
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Set basePrice
     *
     * @param integer $basePrice
     *
     * @return Product
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * Get basePrice
     *
     * @return integer
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * Set specialPrice
     *
     * @param integer $specialPrice
     *
     * @return Product
     */
    public function setSpecialPrice($specialPrice)
    {
        $this->specialPrice = $specialPrice;

        return $this;
    }

    /**
     * Get specialPrice
     *
     * @return integer
     */
    public function getSpecialPrice()
    {
        return $this->specialPrice;
    }

    /**
     * Set cover
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $cover
     *
     * @return Product
     */
    public function setCover(\Application\Sonata\MediaBundle\Entity\Media $cover = null)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Add category
     *
     * @param \WP\CategoryBundle\Entity\Category $category
     *
     * @return Product
     */
    public function addCategory(\WP\CategoryBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \WP\CategoryBundle\Entity\Category $category
     */
    public function removeCategory(\WP\CategoryBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add image
     *
     * @param \WP\ProductBundle\Entity\Product2Media $image
     *
     * @return Product
     */
    public function addImage(\WP\ProductBundle\Entity\Product2Media $image)
    {
        $image->setProduct($this);

        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \WP\ProductBundle\Entity\Product2Media $image
     */
    public function removeImage(\WP\ProductBundle\Entity\Product2Media $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
