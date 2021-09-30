<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Exception;

use Nette\Application\ForbiddenRequestException;
use Throwable;
use WebChemistry\Authorizator\Utility\AuthorizatorUtility;

final class PermissionDeniedException extends ForbiddenRequestException
{

	public function __construct(string|object $subject, ?string $operation = null)
	{
		parent::__construct(
			sprintf(
				'User is not authorized for %s',
				AuthorizatorUtility::debugArguments($subject, $operation)
			)
		);
	}

}
