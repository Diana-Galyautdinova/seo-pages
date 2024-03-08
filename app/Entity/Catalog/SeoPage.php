<?php

namespace App\Entity\Catalog;

//use Anflat\EntityEnum\Deal\Type;
use App\Entity\EntitySeoPage;
use App\Entity\SeoPage as MainSeoPage;
use App\Enum\Catalog\ObjectType;
use Doctrine\ORM\Mapping as ORM;
use Spatie\Sitemap\Tags\Url;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="site_catalog_seo_page",
 * )
 */
class SeoPage extends EntitySeoPage
{
    public static function getStructure()
    {
        return [
            Type::Rent->value => [ // TODO Here is private package from previous job.
                ObjectType::Apartment->value,
                ObjectType::Room->value,
                ObjectType::Bed->value,
                ObjectType::House->value,
                ObjectType::Commerce->value,
            ],
            Type::Sale->value => [
                ObjectType::Apartment->value,
                ObjectType::Room->value,
                ObjectType::House->value,
                ObjectType::Ground->value,
                ObjectType::Garage->value,
                ObjectType::Commerce->value,
            ]
        ];
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="enum_deal_type", nullable=false)
     */
    protected string $dealType;

    /**
     * @ORM\Column(type="enum_object_type", nullable=false)
     */
    protected string $objectType;

    public function __construct(ObjectType $objectType, Type $dealType, MainSeoPage $seoPage)
    {
        parent::__construct($seoPage);
        $this->setObjectType($objectType);
        $this->setDealType($dealType);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Type
     */
    public function getDealType(): Type
    {
        return Type::from($this->dealType);
    }

    /**
     * @param Type $dealType
     */
    public function setDealType(Type $dealType): void
    {
        $this->dealType = $dealType->value;
    }

    /**
     * @return ObjectType
     */
    public function getObjectType(): ObjectType
    {
        return ObjectType::from($this->objectType);
    }

    /**
     * @param ObjectType $objectType
     */
    public function setObjectType(ObjectType $objectType): void
    {
        $this->objectType = $objectType->value;
    }

    public function toSitemapTag(): Url | string | array
    {
        return Url::create($this->url . '/' . $this->getDealType()->value . '/' . $this->getSeoPage()->getSlug());
    }
}
