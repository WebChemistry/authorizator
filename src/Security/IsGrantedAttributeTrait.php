<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Security;

use Nette\Application\UI\ComponentReflection;
use Nette\Application\UI\MethodReflection;
use Nette\Http\IResponse;
use WebChemistry\Authorizator\Security\Attribute\IsGranted;

trait IsGrantedAttributeTrait
{

	private UserIsGrantedMethodInterface $userIsGrantedMethod;

	final public function injectIsGrantedAttributeTrait(
		UserIsGrantedMethodInterface $userIsGrantedMethod
	): void
	{
		$this->userIsGrantedMethod = $userIsGrantedMethod;
	}

	public function checkRequirementsForIsGranted(
		ComponentReflection|MethodReflection $element,
		?callable $errorCallback = null,
	): void
	{
		$attributes = $element->getAttributes(IsGranted::class);
		if (!$attributes) {
			return;
		}
		
		$granted = false;
		foreach ($attributes as $attribute) {
			/** @var IsGranted $object */
			$object = $attribute->newInstance();

			if ($this->userIsGrantedMethod->isGranted($object->getSubject(), $object->getOperation())) {
				$granted = true;

				break;
			}
		}

		if (!$granted) {
			if ($errorCallback) {
				$errorCallback();
			}

			$this->error('User is not authorizated for action', IResponse::S401_UNAUTHORIZED);
		}
	}

}
