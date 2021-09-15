<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator;

use WeakMap;
use WeakReference;
use WebChemistry\Authorizator\Exception\VoterNotFoundException;
use WebChemistry\Authorizator\Utility\AuthorizatorUtility;
use WebChemistry\Authorizator\Voter\CacheableVoterInterface;
use WebChemistry\Authorizator\Voter\FastForwardVoterInterface;
use WebChemistry\Authorizator\Voter\ObjectVoterInterface;
use WebChemistry\Authorizator\Voter\StringVoterInterface;

class Authorizator implements AuthorizatorInterface
{

	private WeakMap $cache;

	/**
	 * @var StringVoterInterface[]
	 */
	private array $stringVoters = [];

	/**
	 * @var ObjectVoterInterface[]
	 */
	private array $objectVoters = [];

	/**
	 * @var ObjectVoterInterface[]
	 */
	private array $fastForwardVoters = [];

	/**
	 * @param StringVoterInterface[] $stringVoters
	 * @param ObjectVoterInterface[] $objectVoters
	 */
	public function __construct(array $stringVoters, array $objectVoters)
	{
		$this->cache = new WeakMap();

		foreach ($stringVoters as $voter) {
			$this->addStringVoter($voter);
		}

		foreach ($objectVoters as $voter) {
			$this->addObjectVoter($voter);
		}
	}

	public function addStringVoter(StringVoterInterface $stringVoter): static
	{
		$this->stringVoters[] = $stringVoter;

		return $this;
	}

	public function addObjectVoter(ObjectVoterInterface $objectVoter): static
	{
		$this->objectVoters[] = $objectVoter;

		return $this;
	}

	public function isGranted(?object $user, object|string $subject, ?string $operation = null): bool
	{
		if (is_string($subject)) {
			if ($user && isset($this->cache[$user][$subject][$operation])) {
				return $this->cache[$user][$subject][$operation];
			}

			foreach ($this->stringVoters as $voter) {
				if ($voter->supports($subject, $operation)) {
					$value = $voter->vote($user, $subject, $operation);
					if ($user && $voter instanceof CacheableVoterInterface && $voter->isCacheable()) {
						if (!isset($this->cache[$user])) {
							$this->cache[$user] = [];
						}

						$this->cache[$user][$subject][$operation] = $value;
					}

					return $value;
				}
			}
		} else {
			foreach ($this->fastForwardVoters[get_class($subject)] ?? [] as $voter) {
				if ($voter->supports($subject, $operation)) {
					return $voter->vote($user, $subject, $operation);
				}
			}

			foreach ($this->objectVoters as $voter) {
				if ($voter->supports($subject, $operation)) {
					return $voter->vote($user, $subject, $operation);
				}
			}
		}

		throw new VoterNotFoundException(
			sprintf('Voter for %s not found', AuthorizatorUtility::printSubjectAndOperation($subject, $operation))
		);
	}

}
