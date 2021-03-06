<?php

namespace MyShop\DefaultBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="MyShop\DefaultBundle\Repository\ProductRepository")
 */
class Product implements \JsonSerializable
{
    const STATUS_AV = 1;
    const STATUS_NONE = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="string", length=200)
    */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     * @Assert\NotBlank(message="Поле модель не должно быть пустым")
     * @Assert\Length(
     *     min = 2,
     *     max = 254,
     *     minMessage="Название модели слишком короткое. Минимум {{ limit }} символов",
     *     maxMessage="Название модели слишком длинное. Максимум {{ limit }} символов"
     * )
     */
    private $model;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Assert\NotBlank(message="Указание цены для товара является обязательным")
     * @Assert\Type(
     *     type="float",
     *     message="Цена должна быть целым или дробным числом"
     * )
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreatedAt", type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     */
    private $dateCreatedAt;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefaultBundle\Entity\Category", inversedBy="productList")
     * @ORM\JoinColumn(name="id_category", referencedColumnName="id", onDelete="CASCADE")
     *
    */
    private $category;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MyShop\DefaultBundle\Entity\ProductPhoto", mappedBy="product")
    */
    private $photos;

    /**
     * @var string
     *
     * @ORM\Column(name="icon_file_name", type="string", length=255, nullable=true)
    */
    private $iconFileName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_show_on_main_page", type="boolean")
    */
    private $isShowOnMainPage;


    public function __construct()
    {
        $date = new \DateTime("now");
        $this->setDateCreatedAt($date);

        $this->photos = new ArrayCollection();

        $this->setIsShowOnMainPage(false);

        $this->status = self::STATUS_AV;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }



    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'model' => $this->getModel(),
            'price' => $this->getPrice()
        ];
    }

    /**
     * @return boolean
     */
    public function getIsShowOnMainPage()
    {
        return $this->isShowOnMainPage;
    }

    /**
     * @param boolean $isShowOnMainPage
     */
    public function setIsShowOnMainPage($isShowOnMainPage)
    {
        $this->isShowOnMainPage = boolval($isShowOnMainPage);
    }

    /**
     * @return string
     */
    public function getIconFileName()
    {
        return $this->iconFileName;
    }

    /**
     * @param string $iconFileName
     */
    public function setIconFileName($iconFileName)
    {
        $this->iconFileName = $iconFileName;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

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
     * Set model
     *
     * @param string $model
     *
     * @return Product
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
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
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set dateCreatedAt
     *
     * @param \DateTime $dateCreatedAt
     *
     * @return Product
     */
    public function setDateCreatedAt($dateCreatedAt)
    {
        $this->dateCreatedAt = $dateCreatedAt;

        return $this;
    }

    /**
     * Get dateCreatedAt
     *
     * @return \DateTime
     */
    public function getDateCreatedAt()
    {
        return $this->dateCreatedAt;
    }

    /**
     * Add photo
     *
     * @param \MyShop\DefaultBundle\Entity\ProductPhoto $photo
     *
     * @return Product
     */
    public function addPhoto(\MyShop\DefaultBundle\Entity\ProductPhoto $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \MyShop\DefaultBundle\Entity\ProductPhoto $photo
     */
    public function removePhoto(\MyShop\DefaultBundle\Entity\ProductPhoto $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}
