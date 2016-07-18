<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 09/05/2016
 * Time: 18:34
 */

namespace Acl\Permission;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class AccessControl extends Acl
{
	protected $roles;
	protected $resources;
	protected $privileges;

	public function __construct(array $roles, array $resources, array $privileges)
	{
		$this->roles      = $roles;
		$this->resources  = $resources;
		$this->privileges = $privileges;

		$this->loadRoles();
		$this->loadResources();
		$this->loadPrivileges();
	}

	protected function loadRoles()
	{
		foreach ($this->roles as $role) {
			if ($role->getParent()) {
				$this->addRole(new Role($role->getName(), $role->getParent()));
			} else {
				$this->addRole(new Role($role->getName()));
			}
			if ((bool)$role->getIsAdmin()) {
				$this->allow($role->getName(), [], []);
			}
		}
	}

	protected function loadResources()
	{
		foreach ($this->resources as $resource) {
			$this->addResource(new Resource($resource->getName()));
		}
	}

	protected function loadPrivileges()
	{
		foreach ($this->privileges as $privilege) {
			$this->allow($privilege->getRole(), $privilege->getResource(), $privilege->getName());
		}
	}
}