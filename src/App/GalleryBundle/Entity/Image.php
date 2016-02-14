<?php

namespace App\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 */
class Image
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $src;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $addDate;

    /**
     * @var \DateTime
     */
    private $updateDate;

    /**
     * @var \App\GalleryBundle\Entity\Album
     */
    private $album;

    /**
     * @var integer
     */
    private $album_id;

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
     * Set src
     *
     * @param string $src
     * @return Image
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string 
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Image
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
     * Set addDate
     *
     * @param \DateTime $addDate
     * @return Image
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * Set current addDate
     *
     * @return Image
     */
    public function setCurrentAddDate()
    {
        $this->addDate = new \DateTime();

        return $this;
    }

    /**
     * Get addDate
     *
     * @return \DateTime 
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Image
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Set current updateDate
     *
     * @return Image
     */
    public function setCurrentUpdateDate()
    {
        $this->updateDate = new \DateTime();

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set album
     *
     * @param \App\GalleryBundle\Entity\Album $album
     * @return Image
     */
    public function setAlbum(\App\GalleryBundle\Entity\Album $album = null)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Get album
     *
     * @return \App\GalleryBundle\Entity\Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * Set album_id
     *
     * @param integer $albumId
     * @return Image
     */
    public function setAlbumId($albumId)
    {
        $this->album_id = $albumId;

        return $this;
    }

    /**
     * Get album_id
     *
     * @return integer 
     */
    public function getAlbumId()
    {
        return $this->album_id;
    }
}
