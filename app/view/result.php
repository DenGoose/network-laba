<?php
/* @var array $params */
$subNetClass = [
	'a' => '255.x.x.x',
	'b' => '255.255.x.x',
	'c' => '255.255.255.x'
];
?>
<div class="mt-5">
	<p>Класс подсети: <strong><?=strtoupper($params['class'])?> (<?=$subNetClass[$params['class']]?>)</strong></p>
	<p>Число битов в сетевой части адреса: <strong><?=$params['prefix']?></strong></p>
	<p>Число битов в узловой части адреса: <strong><?=$params['nodePart']?></strong></p>
	<h4 class="mt-4">Ваша маска подсети: <strong><?=$params['mask']?></strong></h4>
</div>