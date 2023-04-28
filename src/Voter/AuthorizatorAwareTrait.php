<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Voter;

use WebChemistry\Authorizator\AuthorizatorInterface;

trait AuthorizatorAwareTrait
{

	private AuthorizatorInterface $authorizator;

	public function setAuthorizator(AuthorizatorInterface $authorizator): void
	{
		$this->authorizator = $authorizator;
	}

}
