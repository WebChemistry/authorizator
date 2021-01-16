<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator;

use WebChemistry\Authorizator\Exception\VoterNotFoundException;
use WebChemistry\Authorizator\Voter\ObjectVoterInterface;
use WebChemistry\Authorizator\Voter\StringVoterInterface;

class Authorizator implements AuthorizatorInterface
{

	/**
	 * @param StringVoterInterface[] $stringVoters
	 * @param ObjectVoterInterface[] $objectVoters
	 */
	public function __construct(
		private array $stringVoters,
		private array $objectVoters,
	)
	{
	}

	public function isGranted(?object $user, object|string $subject, ?string $operation = null): bool
	{
		if (is_string($subject)) {
			foreach ($this->stringVoters as $voter) {
				if ($voter->supports($subject, $operation)) {
					return $voter->vote($user, $subject, $operation);
				}
			}
		} else {
			foreach ($this->objectVoters as $voter) {
				if ($voter->supports($subject, $operation)) {
					return $voter->vote($user, $subject, $operation);
				}
			}
		}

		throw new VoterNotFoundException(
			sprintf('Voter for subject (%s) and operation (%s) not found', get_debug_type($subject), $operation)
		);
	}

}
