<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Bridge\Nette\Security;

use LogicException;
use ReflectionClass;
use ReflectionMethod;
use WebChemistry\Authorizator\Bridge\Nette\Security\Attribute\IsGranted;
use WebChemistry\Authorizator\Exception\PermissionDeniedException;

trait IsGrantedAttributeTrait
{

	final public function injectIsGrantedAttributeTrait(UserWithIsGrantedMethodInterface $user): void
	{
		if (!property_exists($this, 'onCheckRequirements')) {
			throw new LogicException(
				sprintf('Event onCheckRequirements not exists in %s, please create it.', static::class)
			);
		}

		$this->onCheckRequirements[] = function (ReflectionClass|ReflectionMethod $reflection) use ($user): void {
			$attributes = $reflection->getAttributes(IsGranted::class);
			if (!$attributes) {
				return;
			}

			$granted = false;
			foreach ($attributes as $attribute) {
				/** @var IsGranted $object */
				$object = $attribute->newInstance();

				if ($user->isGranted($object->getSubject(), $object->getOperation())) {
					$granted = true;

					break;
				}
			}

			if (!$granted) {
				throw new PermissionDeniedException('User is not authorizated for action.');
			}
		};
	}

}
