<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Bridge\Nette\DI;

use Nette\Bridges\ApplicationLatte\LatteFactory;
use Nette\DI\CompilerExtension;
use WebChemistry\Authorizator\Authorizator;
use WebChemistry\Authorizator\AuthorizatorInterface;
use WebChemistry\Authorizator\Bridge\Nette\Latte\LatteFunctions;

final class AuthorizatorExtension extends CompilerExtension
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

		$builder->getDefinitionByType(LatteFactory::class)
			->getResultDefinition()
				->addSetup('addFunction', ['isGranted', [$builder->getDefinition($this->prefix('functions')), 'isGranted']]);
	}

}
