<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Security;

interface UserGrantedInterface
{

	public function isGranted(string|object $subject, string $operation): bool;

}
