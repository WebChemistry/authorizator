<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Bridge\Nette\Security\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class IsGranted
{

	/**
	 * @param class-string|string $subject
	 * @param mixed[] $providerOptions
	 */
	public function __construct(
		private string $subject,
		private ?string $operation = null,
		private bool $provider = false,
		private array $providerOptions = [],
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

	public function isProvider(): bool
	{
		return $this->provider;
	}

	/**
	 * @return mixed[]
	 */
	public function getProviderOptions(): array
	{
		return $this->providerOptions;
	}

}
