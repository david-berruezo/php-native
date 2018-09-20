<?php

/**
 * PHP Reference Collection
 * @author bao <contact@nqbao.com>
 **/
class ReferenceCollection implements Countable
{
	protected $vars = array();
	protected $seed = null;
	
	public function __construct()
	{
		$this->seed = uniqid(time());
	}

	public function contains(&$var)
	{
		for ($i = 0;$i < count($this->vars);$i++)
		{
			if ($this->isReference($var,$this->vars[$i]))
			{
				return true;
			}
		}
		
		return false;
	}
	
	public function add(&$var)
	{
		if (!$this->contains($var))
		{
			$this->vars[] =& $var;
		}
	}
	
	public function remove(&$var)
	{
		for ($i = 0;$i < count($this->vars);$i++)
		{
			if ($this->isReference($var,$this->vars[$i]))
			{
				unset($this->vars[$i]);
				$this->vars = array_values($this->vars);
				break;
			}
		}
	}
	
	public function count()
	{
		return count($this->vars);
	}

	/**
	 * Check if two value are referenced to each other
	 **/
	protected function isReference(&$var1,&$var2)
	{
		$result = false;
	
		// two different variables can not be the same reference
		if ($var1 === $var2)
		{
			if (is_object($var1)) // point to the same object
			{
				$result = true;
			}
			else
			{
				$var3 = $var1; // temporary assign by value
				$var1 = $this->seed;
				
				if ($var2 === $this->seed)
				{
					$result = true;
				}
				
				$var1 = $var3;
			}
		}
		
		return $result;
	}
}