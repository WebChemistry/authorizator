<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Voter;

interface VoterInterface
{

	const SKIP = null;

	/**
	 * Returned null skips this voter
	 */
	public function vote(?object $user, object|string $subject, ?string $operation = null): ?bool;

}
