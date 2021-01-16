<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Exception;

use LogicException;

class BadUserIdentityException extends LogicException
{

	public static function create(object $user, string $need): self
	{
		return new self(sprintf('Voter expected %s, %s given', $need, get_debug_type($user)));
	}

}
