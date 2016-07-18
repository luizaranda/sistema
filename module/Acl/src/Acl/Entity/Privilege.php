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
 * Class Privilege
 *
 * @ORM\Table(name="privilege", schema="security")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Acl\Repository\Privilege")
 * @ORM\HasLifecycleCallbacks
 */
class Privilege
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
	 * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
	 */
	protected $role;
	/**
	 * @var integer
	 * @ORM\OneToOne(targetEntity="Acl\Entity\Resource")
	 * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
	 */
	protected $resource;
	/**
	 * @var string
	 * @ORM\Column(name="name", type="string", length=255, nullable=false)
	 */
	protected $name;
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
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return int
	 */
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * @return int
	 */
	public function getResource()
	{
		return $this->resource;
	}


	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getCreatedAt()
	{
		return $this->createdAt->format('d/m/Y H:m:i');
	}

	/**
	 * @return mixed
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt->format('d/m/Y H:m:i');
	}

	/**
	 * @param $id
	 * @return Privilege
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @param int $role
	 * @return Privilege
	 */
	public function setRole($role)
	{
		$this->role = $role;

		return $this;
	}


	/**
	 * @param $resource
	 * @return Privilege
	 */
	public function setResource($resource)
	{
		$this->resource = $resource;

		return $this;
	}


	/**
	 * @param $name
	 * @return Privilege
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return Privilege
	 */
	public function setCreatedAt()
	{
		$this->createdAt = new \DateTime('now');

		return $this;
	}

	/**
	 * @ORM\PreUpdate
	 * @ORM\PrePersist
	 * @return Privilege
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