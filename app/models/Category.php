<?php
namespace app\models;

class Category extends \app\core\Model{
	public $category_id;
	#[\app\validators\NonNull]
	#[\app\validators\NonEmpty]
	protected $category_name;
	public $timestamp;

	// Setters 
	protected function setcategory_name($value){
		$this->category_name = htmlentities($value, ENT_QUOTES);
	}

	// Select Statements

	public function getCategories(){
		$SQL = "SELECT `category`.`category_id`, `category`.`category_name` FROM `category` ORDER BY timestamp DESC;";
		$STH = self::$connection->prepare($SQL);
		$STH->execute();
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Category');
		return $STH->fetchAll();
	}

	public function getByCategoryName($category_name)
	{
		$SQL = 'SELECT * FROM category 
				WHERE category_name = :category_name';
		
		$STH = self::$connection->prepare($SQL);
		$STH->execute(['category_name'=>$category_name]);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Category');
		return $STH->fetch();
	}

	public function getSpecificCategory($category_id){
		$SQL = "SELECT * FROM `category` WHERE category_id=:category_id;";
		$STH = self::$connection->prepare($SQL);
		$STH->execute(['category_id'=>$category_id]);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Category');
		return $STH->fetch();
	}

	// Create, Edit, Delete

	protected function insert()
	{
		$SQL = 'INSERT INTO category(category_name) 
				VALUES (:category_name)';
		
		$STH = self::$connection->prepare($SQL);
		$STH->execute(['category_name'=>$this->category_name,]);
		return self::$connection->lastInsertId();
	}

	protected function update($category_id){
		//only the owner of the message can delete it
		$SQL = "UPDATE `category` SET category_name=:category_name WHERE category_id=:category_id";
		$STH = self::$connection->prepare($SQL);
		$data = [
			'category_name'=>$this->category_name,
			'category_id'=>$category_id,
		];
		$STH->execute($data);
		return $STH->rowCount(); 
	}

	public function delete($category_id){
		//only the owner of the message can delete it
		$SQL = "DELETE FROM category WHERE category_id=:category_id";
		$STH = self::$connection->prepare($SQL);
		$data = ['category_id'=>$category_id];
		$STH->execute($data);
		return $STH->rowCount(); 
	}
}