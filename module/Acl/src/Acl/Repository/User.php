<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 30/04/2016
 * Time: 23:23
 */

namespace Acl\Repository;

use Doctrine\ORM\EntityRepository;

class User extends EntityRepository
{
	/**
	 * Metodo que verifica se o $email e $password passados existem no banco
	 * para fazer a autenticação do usuario.
	 *
	 * @param $email
	 * @param $password
	 * @return bool
	 */
	public function findByEmailAndPassword($email, $password)
	{
		$user = $this->findOneByEmail($email);
		if ($user) {
			$hashPassword = $user->encryptPassword($password);
			if ($hashPassword == $user->getPassword()) {
				return $user;
			}
		}

		return false;
	}

}