<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 08/05/2016
 * Time: 16:34
 */

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;

/**
 * Class Role
 *
 * @ORM\Table(name="role", schema="security")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Acl\Repository\Role")
 * @ORM\HasLifecycleCallbacks
 */
class Role
{
	/**
	 * @var integer
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	protected $id;
	/**
	 * @var integer
	 * @ORM\OneToOne(targetEntity="Acl\Entity\Role")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	protected $parent;
	/**
	 * @var string
	 * @ORM\Column(name="name", type="string", length=255, nullable=false)
	 */
	protected $name;
	/**
	 * @var integer
	 * @ORM\Column(name="is_admin", type="integer", nullable=false)
	 */
	protected $isAdmin;
	/**
	 * @var \DateTime
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	protected $createdAt;
	/**
	 * @var \DateTime
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	protected $updatedAt;


	public function __construct($options = [])
	{
		(new ClassMethods)->hydrate($options, $this);
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return int
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getIsAdmin()
	{
		return $this->isAdmin;
	}


	/**
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt->format('d/m/Y H:m:i');
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt->format('d/m/Y H:m:i');
	}

	/**
	 * @param int $id
	 * @return Role
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @param int $parent
	 * @return Role
	 */
	public function setParent($parent)
	{
		$this->parent = $parent;

		return $this;
	}

	/**
	 * @param string $name
	 * @return Role
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @param int $isAdmin
	 * @return Role
	 */
	public function setIsAdmin($isAdmin)
	{
		$this->isAdmin = $isAdmin;

		return $this;
	}


	/**
	 * @return Role
	 */
	public function setCreatedAt()
	{
		$this->createdAt = new \DateTime('now');

		return $this;
	}

	/**
	 * @ORM\PreUpdate
	 * @ORM\PrePersist
	 * @return Role
	 */
	public function setUpdatedAt()
	{
		$this->updatedAt = new \DateTime('now');

		return $this;
	}

	public function __toString()
	{
		return $this->getName();
	}

	public function toArray()
	{
		//TODO: se não funcionar corretamente esse extract tem que forcar o retorno em array mesmo
		return (new ClassMethods)->extract($this);
	}
}