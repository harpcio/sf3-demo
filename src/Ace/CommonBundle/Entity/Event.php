<?php

namespace Ace\CommonBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ace\CommonBundle\Entity\Repository\EventRepository")
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="intro", type="text")
     */
    private $intro;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Blog", inversedBy="events")
     * @ORM\JoinTable(
     *     name="event_has_blog",
     *     joinColumns={
     *          @ORM\JoinColumn(
     *              name="event_id",
     *              referencedColumnName="id",
     *              nullable=false
     *          )
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(
     *              name="blog_id",
     *              referencedColumnName="id",
     *              nullable=false
     *          )
     *     }
     * )
     */
    private $blogs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(
     *     targetEntity="User",
     *     inversedBy="createdBy"
     * )
     * @ORM\JoinColumn(
     *     name="created_by",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $createdBy;

    public function __construct()
    {
        $this->createAt = new \DateTime();
        $this->blogs = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set intro
     *
     * @param string $intro
     *
     * @return Event
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;

        return $this;
    }

    /**
     * Get intro
     *
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Event
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
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Event
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Event
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return ArrayCollection
     */
    public function getBlogs()
    {
        return $this->blogs;
    }

    /**
     * @param ArrayCollection $blogs
     */
    public function setBlogs($blogs)
    {
        $this->blogs = $blogs;
    }

    /**
     * @param Blog $blog
     *
     * @return Event
     */
    public function addBlog(Blog $blog)
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs->add($blog);
        }

        return $this;
    }

    /**
     * @param Blog $blog
     *
     * @return Event
     */
    public function removeBlog(Blog $blog)
    {
        if ($this->blogs->contains($blog)) {
            $this->blogs->removeElement($blog);
        }

        return $this;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Event
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
     * Set createdBy
     *
     * @param \stdClass $createdBy
     *
     * @return Event
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \stdClass
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function __toString()
    {
        return '(' . $this->getId() . ') ' . $this->getName();
    }
}

