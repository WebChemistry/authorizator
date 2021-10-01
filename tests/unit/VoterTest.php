<?php

namespace Tests\Unit;

use stdClass;
use Tests\ValueObject\Post;
use Tests\Voter\ObjectVoter;
use Tests\Voter\StringVoter;
use WebChemistry\Authorizator\Authorizator;
use WebChemistry\Authorizator\Exception\BadOperationException;
use WebChemistry\Authorizator\Exception\VoterNotFoundException;

class VoterTest extends \Codeception\Test\Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	private Authorizator $authorizator;

	protected function _before()
	{
		$this->authorizator = new Authorizator([
			new StringVoter(),
			new ObjectVoter(),
		]);
	}

	protected function _after()
	{
	}

	// tests
	public function testStringVoter()
	{
		self::assertTrue($this->authorizator->isGranted(null, 'string', 'true'));
		self::assertFalse($this->authorizator->isGranted(null, 'string', 'false'));
	}

	public function testObjectVoter()
	{
		self::assertTrue($this->authorizator->isGranted(null, new Post(), 'true'));
		self::assertFalse($this->authorizator->isGranted(null, new Post(), 'false'));
	}

	public function testObjectVoterNotFound()
	{
		self::expectException(VoterNotFoundException::class);

		$this->authorizator->isGranted(null, new stdClass());
	}

	public function testStringVoterNotFound()
	{
		self::expectException(VoterNotFoundException::class);

		$this->authorizator->isGranted(null, 'not');
	}

	public function testStringVoterOperationNotFound()
	{
		self::expectException(VoterNotFoundException::class);

		$this->authorizator->isGranted(null, 'string', 'not');
	}

	public function testObjectVoterOperationNotFound()
	{
		self::expectException(VoterNotFoundException::class);

		$this->authorizator->isGranted(null, new Post(), 'not');
	}

	public function testSilent()
	{
		$this->authorizator->setSilent(true);
		self::assertFalse($this->authorizator->isGranted(null, new Post(), 'not'));
	}

}
