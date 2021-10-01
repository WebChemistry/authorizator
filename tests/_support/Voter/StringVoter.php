<?php declare(strict_types = 1);

namespace Tests\Voter;

use WebChemistry\Authorizator\Exception\BadOperationException;
use WebChemistry\Authorizator\Voter\VoterInterface;

final class StringVoter implements VoterInterface
{

	public function vote(?object $user, object|string $subject, ?string $operation = null): ?bool
	{
		if ($subject !== 'string') {
			return null;
		}

		return match ($operation) {
			'true' => true,
			'false' => false,
			default => null,
		};
	}

}
