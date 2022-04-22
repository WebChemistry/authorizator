<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Bridge\Nette\Provider;

use Nette\Application\UI\Component;

interface ObjectProviderInterface
{

	/**
	 * @param mixed[] $options
	 */
	public function provide(string $subject, Component $component, array $options = []): object;

}
