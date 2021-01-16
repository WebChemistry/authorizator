<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\DI;

use Latte\Engine;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\CompilerExtension;
use WebChemistry\Authorizator\Authorizator;
use WebChemistry\Authorizator\AuthorizatorInterface;
use WebChemistry\Authorizator\Latte\LatteFunctions;

final class AuthenticatorExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('authorizator'))
			->setType(AuthorizatorInterface::class)
			->setFactory(Authorizator::class);

		$builder->addDefinition($this->prefix('functions'))
			->setFactory(LatteFunctions::class);
	}

	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->getDefinitionByType(ILatteFactory::class)
			->getResultDefinition()
				->addSetup('addFunction', ['isGranted', [$builder->getDefinition($this->prefix('functions')), 'isGranted']]);
	}

}
