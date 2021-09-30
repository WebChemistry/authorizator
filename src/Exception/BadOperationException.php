<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Exception;

use LogicException;

class BadOperationException extends LogicException
{

	public static function create(object $voter, ?string $operation): self
	{
		return new self(
			sprintf('Voter %s not expected operation %s.', get_debug_type($voter), get_debug_type($operation))
		);
	}

}
