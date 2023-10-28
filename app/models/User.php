<?php
namespace app\models;

class User extends \app\core\Model 
{
	public $user_id;
	#[\app\validators\NameLength]
	protected $username;
	public $password_hash;
	public $user_type;
	public $secret_key;

	// Setters
	protected function setusername($value){
		$this->username = htmlentities($value, ENT_QUOTES);
	}

	//Select Statements	

	public function getByUsername($username)
	{
		$SQL = 'SELECT * FROM user 
				WHERE username = :username';
		
		$STH = self::$connection->prepare($SQL);
		$STH->execute(['username'=>$username]);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\User');
		return $STH->fetch();
	}

	public function getByUserType($user_id)
	{
		$SQL = 'SELECT `user_type` FROM user 
				WHERE user_id = :user_id';
		
		$STH = self::$connection->prepare($SQL);
		$STH->execute(['user_id'=>$user_id]);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\User');
		return $STH->fetch();
	}

	public function getByUserId($user_id)
	{
		$SQL = 'SELECT * FROM user 
				WHERE user_id = :user_id';
		
		$STH = self::$connection->prepare($SQL);
		$STH->execute(['user_id'=>$user_id]);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\User');
		return $STH->fetch();
	}

	public function getAllUserInfo()
	{
		$SQL = "SELECT p.status, u.user_id, u.user_type, u.username, p.first_name, p.middle_name, p.last_name, p.email, p.phone_number
			FROM user u
			LEFT JOIN profile p ON u.user_id = p.user_id
			WHERE u.user_type <> 'itspecialist';";

		$STH = self::$connection->prepare($SQL);
		$STH->execute();
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\User');
		
		return $STH->fetchAll();
	}

	public function getUserInfo($user_id)
	{
		
		$SQL = "SELECT p.status, u.user_id, u.user_type,  u.username, p.first_name, p.middle_name, p.last_name, p.email, p.phone_number
			FROM user u
			LEFT JOIN profile p ON u.user_id = p.user_id
			WHERE u.user_id=:user_id";

		$STH = self::$connection->prepare($SQL);
		$data = [
			'user_id'=>$user_id
		];
		$STH->execute($data);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\User');
		return $STH->fetch();
	}

	// Create, Edit, Delete
	
	protected function insert()
	{
		$SQL = 'INSERT INTO user(user_type, username, password_hash) 
				VALUES (:user_type, :username, :password_hash)';
		
		$STH = self::$connection->prepare($SQL);
		$STH->execute(['username'=>$this->username,
						'password_hash'=>$this->password_hash,
						'user_type'=>$this->user_type]);
		return self::$connection->lastInsertId();
	}

	protected function editUser($user_id)
	{
		$SQL = "UPDATE user SET username=:username, user_type=:user_type WHERE user_id=:user_id";
		$STH = self::$connection->prepare($SQL);
		$data = [
			'user_id'=>$user_id,
			'username'=>$this->username,
			'user_type'=>$this->user_type
		];
		$STH->execute($data);
		return $STH->rowCount();
	}

	protected function editUserPassword($user_id)
	{
		$SQL = "UPDATE user SET username=:username, password_hash=:password_hash, user_type=:user_type WHERE user_id=:user_id";
		$STH = self::$connection->prepare($SQL);
		$data = [
			'user_id'=>$user_id,
			'username'=>$this->username,
			'password_hash'=>$this->password_hash,
			'user_type'=>$this->user_type
		];
		$STH->execute($data);
		return $STH->rowCount();
	}

	public function delete($user_id)
	{
		$SQL = "DELETE FROM user WHERE user_id=:user_id";
		$STH = self::$connection->prepare($SQL);
		$data = [
			'user_id'=>$user_id
		];
		$STH->execute($data);
		return $STH->rowCount();
	}

	// Filters

	public function search($username)
	{
		
		$SQL = "SELECT p.status, u.user_id, u.user_type, u.username, p.first_name, p.middle_name, p.last_name, p.email, p.phone_number
			FROM user u
			LEFT JOIN profile p ON u.user_id = p.user_id
			WHERE u.username LIKE :username AND u.user_type <> 'itspecialist'";

		$STH = self::$connection->prepare($SQL);
		$data = [
			'username' => "%$username%"
		];
		$STH->execute($data);
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\User');
		
		return $STH->fetchAll();
	}

	public function getAdmins()
	{
		$SQL = "SELECT p.status, u.user_id, u.user_type, u.username, p.first_name, p.middle_name, p.last_name, p.email, p.phone_number
			FROM user u
			LEFT JOIN profile p ON u.user_id = p.user_id
			WHERE u.user_type = 'admin'";

		$STH = self::$connection->prepare($SQL);
		$STH->execute();
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\User');
		
		return $STH->fetchAll();		
	}

	public function getEmployees()
	{
		$SQL = "SELECT p.status, u.user_id, u.user_type, u.username, p.first_name, p.middle_name, p.last_name, p.email, p.phone_number
			FROM user u
			LEFT JOIN profile p ON u.user_id = p.user_id
			WHERE u.user_type = 'employee'";

		$STH = self::$connection->prepare($SQL);
		$STH->execute();
		$STH->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\User');
		
		return $STH->fetchAll();
	}

	// 2-Factor Authentication

	public function update2fa() {
		$SQL = "UPDATE user SET secret_key=:secret_key WHERE user_id=:user_id";
		$STH = self::$connection->prepare($SQL);
		$data = ['user_id'=>$this->user_id,
				'secret_key'=>$this->secret_key];
		$STH->execute($data);
		return $STH->rowCount();		
	}

	public function getSecretKey() {
		$SQL = "SELECT secret_key FROM user WHERE user_type= 'itspecialist'";
		$STH = self::$connection->prepare($SQL);
		$STH->execute();
		$STH->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\User');
		return $STH->fetch();
	}

}