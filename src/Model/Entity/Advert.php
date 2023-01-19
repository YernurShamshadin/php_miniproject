<?php 

namespace Shamshadinye\MyPhpProject\Model\Entity;

class Advert
{
	private ?int	$id;
	private ?string $title;
	private ?string $description;
	private ?int	$price;
    private ?string $category;
	
	public function __construct($data = [])
	{
		$this->id = $data['id'] ?? null;
		$this->title = $data['title'] ?? null;
		$this->description = $data['description'] ?? null;
		$this->price = $data['price'] ?? null;
        $this->category = $data['category'] ?? null;
	}
	
	public function getId(): ?int
	{
		return $this->id;
	}
    public function setId($id)
    {
        if ($this->id !== null) {
            throw new Exception('id cannot be reset.');
        }
        $this->id = $id;

        return $this;
    }
	public function getTitle(): string
	{
		return $this->title ?? '';
	}
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
	public function getDescription(): string
	{
		return $this->description ?? '';
	}
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
    public function getPrice(): ?int
	{
		return $this->price;
	}
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
    public function getCategory(): string
    {
        return $this->category;
    }
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
}
