<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Security;

interface UserWithIsGrantedMethodInterface
{

	public function isGranted(string|object $subject, ?string $operation = null): bool;

}
