<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Latte;

use WebChemistry\Authorizator\AuthorizatorInterface;
use WebChemistry\Authorizator\Security\UserWithIsGrantedMethodInterface;

final class LatteFunctions
{

	public function __construct(
		private UserWithIsGrantedMethodInterface $user,
		private AuthorizatorInterface $authorizator,
	)
	{
	}

	public function isGranted(string|object $subject, ?string $operation = null, ?object $user = null): bool
	{
		if ($user) {
			return $this->authorizator->isGranted($user, $subject, $operation);
		}

		return $this->user->isGranted($subject, $operation);
	}

}
