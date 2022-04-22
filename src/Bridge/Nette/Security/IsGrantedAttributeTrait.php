<?php declare(strict_types = 1);

namespace WebChemistry\Authorizator\Bridge\Nette\Security;

use LogicException;
use ReflectionClass;
use ReflectionMethod;
use WebChemistry\Authorizator\Bridge\Nette\Provider\ObjectProviderInterface;
use WebChemistry\Authorizator\Bridge\Nette\Security\Attribute\IsGranted;
use WebChemistry\Authorizator\Exception\PermissionDeniedException;

trait IsGrantedAttributeTrait
{

	private UserWithIsGrantedMethodInterface $_isGrantedUser;

	private ?ObjectProviderInterface $_isGrantedObjectProvider;

	final public function injectIsGrantedAttributeTrait(UserWithIsGrantedMethodInterface $user, ?ObjectProviderInterface $objectProvider = null): void
	{
		$this->_isGrantedUser = $user;
		$this->_isGrantedObjectProvider = $objectProvider;

		if (!property_exists($this, 'onCheckRequirements')) {
			throw new LogicException(
				sprintf(
					'Event onCheckRequirements not exists in %s, please create it or call method $this->checkIsGrantedAttribute($reflection) in checkRequirements method.',
					static::class
				)
			);
		}

		$this->onCheckRequirements[] = fn (ReflectionClass|ReflectionMethod $reflection) => $this->checkIsGrantedAttribute($reflection);
	}

	private function checkIsGrantedAttribute(ReflectionClass|ReflectionMethod $reflection): void
	{
		$attributes = $reflection->getAttributes(IsGranted::class);
		if (!$attributes) {
			return;
		}

		$granted = false;
		foreach ($attributes as $attribute) {
			/** @var IsGranted $object */
			$object = $attribute->newInstance();

			$subject = $object->getSubject();

			if ($object->isProvider()) {
				if (!$this->_isGrantedObjectProvider) {
					throw new LogicException(sprintf('Service implements %s does not exist.', ObjectProviderInterface::class));
				}

				$subject = $this->_isGrantedObjectProvider->provide($object->getSubject(), $this, $object->getProviderOptions());
			}

			if ($this->_isGrantedUser->isGranted($subject, $object->getOperation())) {
				$granted = true;

				break;
			}
		}

		if (!$granted) {
			throw PermissionDeniedException::withMessage('User is not authorized for action.');
		}
	}

}
