<?php

namespace App\Controller;

use App\Controller;
use App\ViewManager;
use Silex\Application;

class IndexController extends Controller
{
	public static function init()
	{
		ViewManager::show('header', ['title' => 'Поиск маски для разбиения на подсети']);
		ViewManager::show('CalcForm', $_SESSION);
		ViewManager::show('footer');
		unset($_SESSION['msg']);
		unset($_SESSION['form']);
	}

	public static function calc()
	{
		try
		{
			$_SESSION['result'] = (new \App\Network\SubNet(
				$_POST['class'],
				$_POST['subnet-count'],
				$_POST['subnet-devices'])
			)->calculate();
			header('Location: /result/');
			die();
		}catch (\Throwable $e)
		{
			$_SESSION['form'] = $_POST;
			$_SESSION['msg'] = $e->getMessage();
			header('Location: /');
			die();
		}
	}
}