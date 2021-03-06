<?php

namespace mageekguy\atoum\asserters;

use
	mageekguy\atoum\asserter,
	mageekguy\atoum\exceptions,
	mageekguy\atoum\asserters\adapter,
	mageekguy\atoum\test\adapter\call\decorators
;

class mock extends adapter
{
	public function setWith($mock)
	{
		if ($mock instanceof \mageekguy\atoum\mock\aggregator === false)
		{
			$this->fail(sprintf($this->getLocale()->_('%s is not a mock'), $this->getTypeOf($mock)));
		}
		else
		{
			parent::setWith($mock->getMockController())->call->setDecorator(new decorators\addClass($mock->getMockController()->getMockClass()));
		}

		return $this;
	}

	public function wasCalled($failMessage = null)
	{
		if (sizeof($this->adapterIsSet()->adapter->getCalls()) > 0)
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('%s is not called'), $this->adapter->getMockClass()));
		}

		return $this;
	}

	public function wasNotCalled($failMessage = null)
	{
		if (sizeof($this->adapterIsSet()->adapter->getCalls()) <= 0)
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('%s is called'), $this->adapter->getMockClass()));
		}

		return $this;
	}

	protected function adapterIsSet()
	{
		try
		{
			return parent::adapterIsSet();
		}
		catch (adapter\exceptions\logic $exception)
		{
			throw new mock\exceptions\logic('Mock is undefined');
		}
	}

	protected function callIsSet()
	{
		try
		{
			return parent::callIsSet();
		}
		catch (adapter\exceptions\logic $exception)
		{
			throw new mock\exceptions\logic('Call is undefined');
		}
	}
}
