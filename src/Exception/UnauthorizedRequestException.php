<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Exception;

use Nette\Application\BadRequestException;
use Nette\Http\IResponse;

final class UnauthorizedRequestException extends BadRequestException
{

	public function __construct(string $message)
	{
		parent::__construct($message, IResponse::S401_UNAUTHORIZED);
	}

}
