<?php

namespace App\Network;

class SubNet
{
	public const BYTE = 8;
	public const IP_CLASSES = ['a', 'b', 'c'];
	protected int $prefixSubNetPart = 0;
	protected int $prefix = 0;
	protected int $nodeComputersNumber;

	/**
	 * @throws \Exception
	 */
	public function __construct(
		protected string $ipClass,
		protected int    $subnetCount,
		protected int 	 $computersNumber
	)
	{
		if (!in_array($this->ipClass, self::IP_CLASSES))
		{
			throw new \Exception('Класс может быть только A, B или C');
		}
		if (!intval($this->computersNumber))
		{
			throw new \Exception('Количество устройств не может быть меньше одного');
		}
		if (!intval($this->subnetCount))
		{
			throw new \Exception('Количество подсетей не может быть меньше одного');
		}

		$powerOf2 = log($this->subnetCount) / log(2);

		if ($this->subnetCount > 0 && $this->subnetCount < 1024 && $powerOf2 > 0 && ($powerOf2 / floor($powerOf2)) == 1)
		{
			$this->prefixSubNetPart = (ceil($powerOf2)) + 1;
		}
		else
		{
			$this->prefixSubNetPart = (ceil($powerOf2));
		}

		$subNetClass = array_search($this->ipClass, self::IP_CLASSES) + 1;
		$this->prefix = (static::BYTE * $subNetClass) + $this->prefixSubNetPart;

		if ($this->prefix >= 32)
		{
			throw new \Exception('Разбиение на подсети невозможно.');
		}

		$this->nodeComputersNumber = pow(2, (32 - $this->prefix)) - 2;

		if ($this->nodeComputersNumber < $this->computersNumber)
		{
			throw new \Exception("Разбиение на подсети невозможно");
		}
	}

	/**
	 * @throws \Exception
	 */
	public function calculate(): array
	{
		$one = str_repeat('1', $this->prefix);
		$binary = $one . str_repeat('0', 32 - $this->prefix);
		$result = [
			'prefix' => $this->prefix,
			'nodePart' => 32 - $this->prefix,
			'nodeComputersNumber' => $this->nodeComputersNumber,
			'class' => $this->ipClass,
			'binary' => implode('.', str_split($binary, self::BYTE))
		];

		if ($this->computersNumber <= $this->nodeComputersNumber)
		{
			$mask = match ($this->ipClass)
			{
				'a' => $this->getMaskFor('255'),
				'b' => $this->getMaskFor('255.255'),
				'c' => $this->getMaskFor('255.255.255'),
				default => throw new \Exception('Ошибка при подсчёте маски'),
			};

			$result['mask'] = $mask;
		}
		else
		{
			throw new \Exception('Число желаемых подсетей превышает число возможных компьютеров в подсети');
		}

		return $result;
	}

	protected function getMaskFor($classMask): string
	{
		if ($this->prefixSubNetPart > 8 && $classMask != '255.255.255')
		{
			$partNodePart = $this->prefixSubNetPart;
			while ($partNodePart > 8)
			{
				$classMask .= '.' . $this->maskCalculate(8);
				$partNodePart -= 8;
			}
			$classMask .= '.' . $this->maskCalculate($partNodePart);
		}
		else
		{
			$classMask .= '.' . $this->maskCalculate($this->prefixSubNetPart);
		}

		$arr = explode('.', $classMask);
		while (count($arr) <= 3)
		{
			$arr[] = '0';
		}

		return implode('.', $arr);
	}

	protected function maskCalculate(int $numberBits, int $mask = 0): int
	{
		return $numberBits > 0 ?
			$this->maskCalculate($numberBits - 1, $mask + pow(2, 8 - $numberBits)) :
			$mask;
	}
}