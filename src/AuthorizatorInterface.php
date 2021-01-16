<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator;

interface AuthorizatorInterface
{

	public function isGranted(object $user, string|object $subject, string $operation): bool;

}
