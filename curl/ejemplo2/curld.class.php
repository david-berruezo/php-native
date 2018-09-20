<?php

Class curld {

	public function download ($data, $simultaneous = 1)
	{
		$loops = array_chunk($data, $simultaneous, true);

		foreach ($loops as $key => $value)
		{
			foreach ($value as $urlkey => $urlvalue)
			{
				$ch[$urlkey] = curl_init($urlvalue["url"]);
				curl_setopt($ch[$urlkey], CURLOPT_RETURNTRANSFER, true);
			}

			$mh = curl_multi_init();

			foreach ($value as $urlkey => $urlvalue)
			{
				curl_multi_add_handle($mh, $ch[$urlkey]);
			}

			$running = null;
			do {
				curl_multi_exec($mh, $running);
			} while ($running);

			foreach ($value as $urlkey => $urlvalue)
			{
				$response = curl_multi_getcontent($ch[$urlkey]);
				file_put_contents($urlvalue["saveas"], $response);
				curl_multi_remove_handle($mh,$ch[$urlkey]);
				curl_close($ch[$urlkey]);
			}

		}
	}
}

?>