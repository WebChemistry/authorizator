<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Voter;

interface StringVoterInterface
{

	public function supports(string $subject, string $operation): bool;

	public function vote(?object $user, string $subject, string $operation): bool;

}
