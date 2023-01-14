<?php

namespace Shamshadinye\MyPhpProject\Model\Repository;

use Shamshadinye\MyPhpProject\Model\Entity\Advert;

class   AdvertRepository
{
	private const DB_PATH = '../storage/adverts.json';
	
	public function getAll(): array
	{
		$result = [];
		
		foreach ($this->getDB() as $advertData) {
			$result[] = new Advert($advertData);
		}
		
		return $result;	
	}

    public function getOne(int $id): Advert
    {
        $db			= $this->getDB();
        $advertData = $db[$id];

        return new Advert($advertData);
    }
	
	public function create(array $advertData): Advert {
		$db			= $this->getDB();
		$increment 	= array_key_last($db) + 1;
		$advertData['id'] = $increment;
		$db[$increment]	= $advertData;
		
		$this->saveDB($db);
		
		return new Advert($advertData);
	}
    public function update(array $advertData, int $id): Advert {
        $db			= $this->getDB();
        $advertData['id'] = $id;
        $db[$id] = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);
    }
	
	private function getDB(): array
	{
        return json_decode(file_get_contents(self::DB_PATH), true) ?? [];
	}
	
	private function saveDB(array $data):void
	{
        file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
	}
}

