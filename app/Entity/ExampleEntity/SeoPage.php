<?php

namespace App\Entity\ExampleEntity;

use App\Entity\EntitySeoPage;
use App\Entity\SeoPage as MainSeoPage;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="example_entity_seo_page",
 * )
 */
class SeoPage extends EntitySeoPage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected string $additionalField;

    public function __construct(string $additionalField, MainSeoPage $seoPage)
    {
        parent::__construct($seoPage);
        $this->setAdditionalField($additionalField);
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
     * @return string
     */
    public function getAdditionalField(): string
    {
        return $this->additionalField;
    }

    /**
     * @param string $additionalField
     */
    public function setAdditionalField(string $additionalField): void
    {
        $this->additionalField = $additionalField;
    }
}
