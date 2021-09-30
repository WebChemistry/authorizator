<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Utility;

final class AuthorizatorUtility
{

	public static function debugArguments(?object $user, object|string $subject, ?string $operation = null): string
	{
		return sprintf(
			'user (%s) and subject (%s) and operation (%s)',
			$user === null ? 'null' : get_debug_type($user),
			is_string($subject) ? $subject : get_debug_type($subject),
			is_string($operation) ? $operation : 'null'
		);
	}

}
