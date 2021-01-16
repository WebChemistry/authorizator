<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\DI;

use Nette\DI\CompilerExtension;
use WebChemistry\Authorizator\Authorizator;
use WebChemistry\Authorizator\AuthorizatorInterface;

final class AuthenticatorExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('authorizator'))
			->setType(AuthorizatorInterface::class)
			->setFactory(Authorizator::class);
	}

}
