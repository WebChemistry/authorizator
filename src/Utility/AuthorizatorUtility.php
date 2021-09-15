<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Utility;

final class AuthorizatorUtility
{

	public static function printSubjectAndOperation(object|string $subject, ?string $operation = null): string
	{
		return sprintf(
			'subject (%s) and operation (%s)',
			is_string($subject) ? $subject : get_debug_type($subject),
			is_string($operation) ? $operation : 'null'
		);
	}

}
