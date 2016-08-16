<?php

/**
 * LICENSE : This file is part of Eco4.
 *
 * My Agile Product is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * My Agile Product is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event entity class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 *
 * @ORM\Table(name="echo_event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
{
    const CAT_UPGRADE = 1;
    
    const OT_MINE = 1;
    
    const STATUS_PLANNED  = 1;
    const STATUS_DONE     = 2;
    const STATUS_CANCELED = 3;
    
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
     *
     * @ORM\Column(name="category", type="integer")
     */
    protected $category;

    /**
     * @var int
     *
     * @ORM\Column(name="object_type", type="integer")
     */
    protected $objectType;
    
    /**
     * @var int
     *
     * @ORM\Column(name="object_id", type="integer")
     */
    private $objectId;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_event", type="datetime")
     */
    private $eventDatetime;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;
    

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
     * Set Category of event
     *
     * @param int $category Category of event
     *
     * @return Event
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
    
    /**
     * Get Category of event
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set type of object
     *
     * @param int Type of object
     *
     * @return Event
     */
    public function setObjectType($type)
    {
        $this->objectType = $type;

        return $this;
    }

    /**
     * Get type of object
     *
     * @return int
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * Set object id
     *
     * @param integer $id Id of object
     *
     * @return Event
     */
    public function setObjectId($id)
    {
        $this->objectId = $id;

        return $this;
    }

    /**
     * Get object id
     *
     * @return int
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Set date time of event
     *
     * @param DateTime $datetime
     *
     * @return Event
     */
    public function setEventDatetime($datetime)
    {
        $this->eventDatetime = $datetime;

        return $this;
    }

    /**
     * Get date time of event
     *
     * @return DateTime
     */
    public function getEventDatetime()
    {
        return $this->eventDatetime;
    }
       
    /**
     * Get status of event
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status of event
     *
     * @param int Status of event
     *
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    } 
}

