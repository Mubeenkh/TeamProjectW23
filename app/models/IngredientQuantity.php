<?php
namespace app\models;

use app\core\TimeHelper;

class IngredientQuantity extends \app\core\Model {

	public $iq_id;
	public $ingredient_id;
	public $arrival_date;
	public $expired_date;
	#[\app\validators\Number]
	protected $quantity;
	#[\app\validators\Number]
	protected $price;

	// Setters

	protected function setquantity($value){
		$this->quantity = htmlentities($value, ENT_QUOTES);
	}

	protected function setprice($value){
		$this->price = htmlentities($value, ENT_QUOTES);
	}

	// Select Statements

	public function getAll($ingredient_id) {
		$SQL = 'SELECT `iq_id`, `ingredient_id`, `arrival_date`, `expired_date`, `quantity`, `price`, DATEDIFF(expired_date, CURRENT_DATE()) AS daysLeft FROM ingredient_quantity WHERE ingredient_id=:ingredient_id';
		$STH = self::$connection->prepare($SQL);
		$data = ['ingredient_id'=>$ingredient_id];
		$STH->execute($data);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\IngredientQuantity');
		return $STH->fetchAll();
	}

	public function getTotalQuantity($ingredient_id){
		$SQL = "SELECT SUM(quantity) AS `fullQuantity` FROM `ingredient_quantity` WHERE `ingredient_id` = :ingredient_id;";
		$STH = self::$connection->prepare($SQL);
		$data = ['ingredient_id'=>$ingredient_id];
		$STH->execute($data);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\IngredientQuantity');
		return $STH->fetch();
	}

	public function getOneQuantity($iq_id) {
		$SQL = 'SELECT `iq_id`, `ingredient_id`, `arrival_date`, `expired_date`, `quantity`, `price` FROM ingredient_quantity WHERE iq_id=:iq_id';
		$STH = self::$connection->prepare($SQL);
		$data = [
				'iq_id'=>$iq_id];
		$STH->execute($data);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\IngredientQuantity');
		return $STH->fetch();
	}

	// Create, Edit, Delete

	protected function addIngredientQuantity($ingredient_id) {
		$SQL = "INSERT INTO `ingredient_quantity` (`iq_id`, `ingredient_id`, `arrival_date`, `expired_date`, `quantity`, `price`) value (:iq_id, :ingredient_id, :arrival_date, :expired_date, :quantity, :price)";
		$STH = self::$connection->prepare($SQL);
		$data = ['iq_id'=>$this->iq_id,
				'ingredient_id'=>$ingredient_id,
				'arrival_date'=>$this->arrival_date,
				'expired_date'=>$this->expired_date,
				'quantity'=>$this->quantity,
				'price'=>$this->price];
		$STH->execute($data);
		return self::$connection->lastInsertId();
	}

	protected function editQuantity($iq_id) {
		$SQL = "UPDATE `ingredient_quantity` SET `arrival_date`=:arrival_date, `expired_date`=:expired_date, `quantity`=:quantity, `price`=:price WHERE iq_id=:iq_id;";
		$STH = self::$connection->prepare($SQL);
		$data = ['iq_id'=>$iq_id,
				'arrival_date'=>$this->arrival_date,
				'expired_date'=>$this->expired_date,
				'quantity'=>$this->quantity,
				'price'=>$this->price];
		$STH->execute($data);
		return $STH->rowCount();		
	}

	protected function quantityUpdate($iq_id) {
		$SQL = "UPDATE `ingredient_quantity` SET `quantity`=:quantity WHERE iq_id=:iq_id;";
		$STH = self::$connection->prepare($SQL);
		$data = [
			'iq_id'=>$iq_id,
			'quantity'=>$this->quantity
		];
		$STH->execute($data);
		return $STH->rowCount();		
	}

	public function deleteQuantity($iq_id){
		$SQL = "DELETE FROM `ingredient_quantity` WHERE iq_id=:iq_id;";
		$STH = self::$connection->prepare($SQL);
		$data = ['iq_id'=>$iq_id];
		$STH->execute($data);
		return $STH->rowCount(); 
	}
}