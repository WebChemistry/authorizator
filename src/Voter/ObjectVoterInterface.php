<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Voter;

interface ObjectVoterInterface
{

	public function supports(object $subject, string $operation): bool;

	public function vote(?object $user, object $subject, string $operation): bool;

}
