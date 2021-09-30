<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator;

use WebChemistry\Authorizator\Exception\VoterNotFoundException;
use WebChemistry\Authorizator\Utility\AuthorizatorUtility;
use WebChemistry\Authorizator\Voter\VoterInterface;

class Authorizator implements AuthorizatorInterface
{

	/**
	 * @param VoterInterface[] $voters
	 */
	public function __construct(
		private array $voters,
	)
	{
	}

	public function addVoter(VoterInterface $voter): static
	{
		$this->voters[] = $voter;

		return $this;
	}

	public function isGranted(
		?object $user,
		object|string $subject,
		?string $operation = null,
		string $strategy = 'affirmative'
	): bool
	{
		foreach ($this->voters as $voter) {
			$result = $voter->vote($user, $subject, $operation);

			if ($result === null) {
				continue;
			}

			return $result;
		}

		throw new VoterNotFoundException(
			sprintf('Voter for %s nad not found.', AuthorizatorUtility::debugArguments($user, $subject, $operation))
		);
	}

}
