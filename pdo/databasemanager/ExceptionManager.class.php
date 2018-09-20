<?php
	class ExceptionManager
	{
		public function __construct()
		{
			//echo "Initialized";
		}

		public function returnError($errorStack)
		{
			//print_r($errorStack);
			if ($errorStack instanceof Exception)
			{
				print_r($errorStack);
			}
			else
			{
				echo $errorStack;
			}
		}
	}
?>