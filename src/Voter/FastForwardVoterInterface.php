<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Voter;

interface FastForwardVoterInterface extends ObjectVoterInterface
{

	public function getFastForward(): string;

}
