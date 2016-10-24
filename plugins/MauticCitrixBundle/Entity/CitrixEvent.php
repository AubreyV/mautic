<?php
/**
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCitrixBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use MauticPlugin\MauticCitrixBundle\Helper\BasicEnum;

abstract class CitrixEventTypes extends BasicEnum
{
    // Used for querying events
    const REGISTERED = 'registered';
    const ATTENDED = 'attended';
}

/**
 *
 * @ORM\Table(name="plugin_citrix_events")
 * @ORM\Entity
 *
 */
class CitrixEvent
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="product", type="string", length=20)
     */
    protected $product;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     */
    protected $email;

    /**
     * @ORM\Column(name="event_name", type="string", length=255)
     */
    protected $eventName;

    /**
     * @ORM\Column(name="event_type", type="string", length=50)
     */
    protected $eventType;

    /**
     * @ORM\Column(name="event_date", type="datetime")
     */
    protected $eventDate;

    public function __construct()
    {
        $this->product = 'undefined';
        $this->email = 'undefined';
        $this->eventName = 'undefined';
        $this->eventDate = new \Datetime;
        $this->eventType = 'undefined';
    }

    /**
     * @param ORM\ClassMetadata $metadata
     */
    public static function loadMetadata(ORM\ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setTable('plugin_citrix_events')
            ->setCustomRepositoryClass('MauticPlugin\MauticCitrixBundle\Entity\CitrixEventRepository')
            ->addIndex(['product', 'email'], 'citrix_event_email')
            ->addIndex(['product', 'event_name', 'event_type'], 'citrix_event_name')
            ->addIndex(['product', 'event_type', 'event_date'], 'citrix_event_type')
            ->addIndex(['product', 'email', 'event_type'], 'citrix_event_product')
            ->addIndex(['product', 'email', 'event_type', 'event_name'], 'citrix_event_product_name')
            ->addIndex(['event_date'], 'citrix_event_date');
        $builder->addId();
        $builder->addNamedField('product', 'string', 'product');
        $builder->addNamedField('email', 'string', 'email');
        $builder->addNamedField('eventName', 'string', 'event_name');
        $builder->createField('eventType', 'string')
            ->columnName('event_type')
            ->length(50)
            ->build();
        $builder->addNamedField('eventDate', 'datetime', 'event_date');
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param string $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    /**
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * @param \DateTime $eventDate
     */
    public function setEventDate(\DateTime $eventDate)
    {
        $this->eventDate = $eventDate;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }
}