<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Voter;

use WebChemistry\Authorizator\AuthorizatorInterface;

interface AuthorizatorAwareInterface
{

	public function setAuthorizator(AuthorizatorInterface $authorizator);

}
