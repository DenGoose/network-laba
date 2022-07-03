<?php

namespace App\Controller;

use App\ViewManager;

class ResultController extends \App\Controller
{
	public static function init()
	{
		$result = $_SESSION['result'];
		unset($_SESSION['result']);

		if (!is_array($result))
		{
			header('Location: /');
			die();
		}

		ViewManager::show('header', ['title' => 'Маска для разбиения на подсети']);
		ViewManager::show('result', $result);
		ViewManager::show('footer');
	}
}