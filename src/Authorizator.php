<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator;

use Tracy\ILogger;
use WebChemistry\Authorizator\Exception\VoterNotFoundException;
use WebChemistry\Authorizator\Utility\AuthorizatorUtility;
use WebChemistry\Authorizator\Voter\AuthorizatorAwareInterface;
use WebChemistry\Authorizator\Voter\CacheableVoterInterface;
use WebChemistry\Authorizator\Voter\VoterInterface;

class Authorizator implements AuthorizatorInterface
{

	private int $depth = 0;

	/**
	 * @param VoterInterface[] $voters
	 */
	public function __construct(
		private array $voters,
		private ?ILogger $logger = null,
		private bool $silent = false,
	)
	{
		foreach ($this->voters as $voter) {
			if ($voter instanceof AuthorizatorAwareInterface) {
				$voter->setAuthorizator($this);
			}
		}
	}

	public function setSilent(bool $silent): static
	{
		$this->silent = $silent;

		return $this;
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
		if ($this->depth > 15) {
			throw new \LogicException('Circular reference detected.');
		}

		$this->depth++;

		foreach ($this->voters as $voter) {
			$result = $voter->vote($user, $subject, $operation);

			if ($result === null) {
				continue;
			}

			$this->depth--;

			return $result;
		}

		$this->depth--;

		$exception = new VoterNotFoundException(
			sprintf('Voter for %s not found.', AuthorizatorUtility::debugArguments($user, $subject, $operation))
		);

		if ($this->silent) {
			$this->logger?->log($exception);

			return false;
		}

		throw $exception;
	}

}
