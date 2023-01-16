<?php

namespace Shamshadinye\MyPhpProject\Model\Repository;

use Shamshadinye\MyPhpProject\Model\Entity\Advert;
use PDO;

class   AdvertRepository
{
    public function getAll(): array
	{
        $stmt = $this->connect()->query(
            'SELECT
                id,
                title,
                description,
                price
            FROM adverts'
        );

        $result = $stmt -> fetchAll();

        $advert = [];
        foreach( $result as $row ) {
            $advert[] = new Advert($row);
        }

        return $advert;
	}

    public function findById(int $id): Advert
    {
        $stmt = $this->connect()->prepare(
            'SELECT
                id,
                title,
                description,
                price
            FROM adverts
            WHERE id = :id
            LIMIT 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Advert($result);
    }
	
	public function create(array $advertData): Advert {
        $stmt = $this->connect()->prepare(
            'INSERT INTO adverts (
                title,
                description,
                price
            ) VALUES (
                :title,
                :description,
                :price
            )'
        );
        $stmt->bindValue(':title', $advertData['title'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $advertData['description'], PDO::PARAM_STR);
        $stmt->bindValue(':price', $advertData['price'], PDO::PARAM_INT);
        $stmt->execute();

        $advertData['id']=$this->connect()->lastInsertId();

        return new Advert($advertData);
	}
    public function update(array $advertData, int $id): Advert {
        $stmt = $this->connect()->prepare(
            'UPDATE adverts SET
                title = :title,
                description = :description,
                price = :price
                WHERE id = :id'
        );
        $stmt->bindValue(':title', $advertData['title'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $advertData['description'], PDO::PARAM_STR);
        $stmt->bindValue(':price', $advertData['price'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $advertData['id']=$id;
        return new Advert($advertData);
    }
    private function connect()
    {
        $pdo = null;
        $host = 'localhost';
        $db = 'db_for_php_miniproject';
        $user = 'testuser';
        $pass = 'testpassword';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, $options);
        } catch (PDOException $e) {
            echo 'DB connection error'.$e->getMessage();
        }
        return $pdo;
    }
}

