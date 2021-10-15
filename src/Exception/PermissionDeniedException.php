<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Exception;

use Nette\Application\ForbiddenRequestException;
use Throwable;
use WebChemistry\Authorizator\Utility\AuthorizatorUtility;

final class PermissionDeniedException extends ForbiddenRequestException
{

	public function __construct(?object $user, string|object $subject, ?string $operation = null)
	{
		parent::__construct(
			sprintf(
				'Not authorized. %s',
				ucfirst(AuthorizatorUtility::debugArguments($user, $subject, $operation))
			)
		);
	}

	public static function withMessage(string $message): self
	{
		$expection = new self(null, '', null);
		$expection->message = $message;

		return $expection;
	}

}
