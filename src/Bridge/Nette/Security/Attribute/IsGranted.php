<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Bridge\Nette\Security\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class IsGranted
{

	public function __construct(
		private string $subject,
		private ?string $operation = null,
	)
	{
	}

	public function getSubject(): string
	{
		return $this->subject;
	}

	public function getOperation(): ?string
	{
		return $this->operation;
	}

}
