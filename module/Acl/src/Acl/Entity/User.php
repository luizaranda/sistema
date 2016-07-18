<?php

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;
use Zend\Math\Rand;
use Zend\Crypt\Key\Derivation\Pbkdf2;

/**
 * Class User
 *
 * @ORM\Table(name="user", schema="security")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Acl\Repository\User")
 * @ORM\HasLifecycleCallbacks
 */
class User
{

	/**
	 * @var integer
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var integer
	 * @ORM\OneToOne(targetEntity="Acl\Entity\Role")
	 * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
	 */
	private $role;

	/**
	 * @var string
	 * @ORM\Column(name="name", type="string", length=255, nullable=false)
	 */
	private $name;

	/**
	 * @var string
	 * @ORM\Column(name="email", type="string", length=255, nullable=false)
	 */
	private $email;

	/**
	 * @var string
	 * @ORM\Column(name="password", type="string", length=255, nullable=false)
	 */
	private $password;

	/**
	 * @var string
	 * @ORM\Column(name="salt", type="string", length=255, nullable=false)
	 */
	private $salt;

	/**
	 * @var integer
	 * @ORM\Column(name="active", type="integer", nullable=true)
	 */
	private $active = 0;

	/**
	 * @var string
	 * @ORM\Column(name="activation_key", type="string", length=255, nullable=false)
	 */
	private $activationKey;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	private $updatedAt;

	public function __construct($options = [])
	{
		(new ClassMethods)->hydrate($options, $this);
		$this->createdAt     = new \DateTime("now");
		$this->updatedAt     = new \DateTime("now");
		$this->salt          = base64_encode(Rand::getBytes(8, true));
		$this->activationKey = md5($this->email . $this->salt);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getRole()
	{
		return $this->role;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getSalt()
	{
		return $this->salt;
	}

	public function getActive()
	{
		return $this->active;
	}

	public function getActivationKey()
	{
		return $this->activationKey;
	}

	public function getCreatedAt()
	{
		return $this->createdAt->format('d/m/Y H:m:i');
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt->format('d/m/Y H:m:i');
	}

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @param int $role
	 * @return User
	 */
	public function setRole($role)
	{
		$this->role = $role;

		return $this;
	}


	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	public function setPassword($password)
	{
		$this->password = $this->encryptPassword($password);

		return $this;
	}

	public function setSalt($salt)
	{
		$this->salt = $salt;

		return $this;
	}

	public function setActive($active)
	{
		$this->active = $active;

		return $this;
	}

	public function setActivationKey($activationKey)
	{
		$this->activationKey = $activationKey;

		return $this;
	}

	public function setCreatedAt()
	{
		$this->createdAt = new \DateTime('now');
	}

	/**
	 * @ORM\PrePersist
	 */
	public function setUpdatedAt()
	{
		$this->updatedAt = new \DateTime('now');
	}

	public function encryptPassword($password)
	{
		return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 10000, (strlen($password) * 2)));
	}

	public function toArray()
	{
		return (new ClassMethods)->extract($this);
	}
}
