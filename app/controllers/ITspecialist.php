<?php
namespace app\controllers;

use \app\models\User;
use \app\models\Profile;
#[\app\filters\ITSpecialist]
 // #[\app\filters\TwoFactor]
class ITspecialist extends \app\core\Controller 
{
    // Viewing

	public function index() 
	{
        $user = new User();
        $users = $user->getAllUserInfo();
        $this->view('ITspecialist/index', $users);
	}

    public function userDetails($user_id)
    {
        $profile = new Profile();
        $userdetails = $profile->getProfile($user_id);

        if($userdetails){
            $user = new User();
            $users = $user->getUserInfo($user_id);
            $this->view('ITspecialist/userDetails', $users);
        }else{
            header('location:/ITspecialist/createProfile/' . $user_id);
        }
    }

    //Create, Edit, Delete

	public function createUser()
	{

        if(isset($_POST['action']))
        {
            $user = new User();
            $usercheck = $user->getByUsername($_POST['username']);
            if(!$usercheck)
            {
                if ($_POST['username'] != '' 
                    && $_POST['username'] != null 
                    && $_POST['password'] != '' 
                    && $_POST['password'] != null
                    && $_POST['user_type'] != ''
                    && $_POST['user_type'] != null) 
                {
                    $user->username = htmlentities($_POST['username']);
                    $user->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $user->user_type = htmlentities($_POST['user_type']);
                    $user->user_id = $user->insert();

                    header('location:/ITspecialist/createProfile/' . $user->user_id);
                }
                else
                {
                    header('location:/ITspecialist/createUser?error=Please enter all criteria.');
                }
            } 
            else 
            {
                header('location:/ITspecialist/createUser?error=Username @' . $_POST['username'] . ' already in use.');
            }
        } 
        else 
        {
            $this->view('ITspecialist/createUser');
        }
	}

    public function createProfile($user_id)
    {
        if(isset($_POST['action']))
        {
            if($_POST['first_name'] != '' && $_POST['last_name'] != '' && $_POST['email'] != '' && $_POST['phone_number'] != '' && $_POST['status'] != ''
                && $_POST['first_name'] != null && $_POST['last_name'] != null && $_POST['email'] != null && $_POST['phone_number'] != null && $_POST['status'] != null){

                $profile = new Profile();
                $profile->user_id = $user_id;
                $profile->first_name = htmlentities($_POST['first_name']);
                $profile->middle_name = htmlentities($_POST['middle_name']);
                $profile->last_name = htmlentities($_POST['last_name']);
                $profile->email = htmlentities($_POST['email']);
                $profile->phone_number = htmlentities($_POST['phone_number']);
                $profile->status = htmlentities($_POST['status']);

                $success = $profile->insert();
                echo "$success";

                if($success)
                {
                    header('location:/ITspecialist/index?success=New User Created');
                }else{
                    header('location:/ITspecialist/createProfile/' . $user_id.'?error=Something went wrong');
                }
            }else{
                header('location:/ITspecialist/createProfile/' . $user_id.'?error=Please fill the fields. (Exception: Middle Name)');
            }
        } 
        else 
        {
            $user = new User();
            $usercheck = $user->getByUserId($user_id);
            $this->view('ITspecialist/createProfile', $usercheck);
        }
    }

    public function delete($user_id)
    {
        
        $profile = new Profile();
        $success = $profile->delete($user_id);

        if($success){
            $user = new User();
            $user->delete($user_id);
            header('location:/ITspecialist/index?success=Profile for user has been deleted');
        }else{
            header('location:/ITspecialist/userDetails/$user_id?error=Profile for user ID ' . $user_id . ' was not deleted');
        }
    }

    public function edit($user_id)
    {
        $user = new User();
        $user = $user->getUserInfo($user_id);
        $this->view('ITspecialist/edit', $user);
    }

    public function editProfile($user_id)
    {
        if(isset($_POST['editProfile']))
        {
            if($_POST['first_name'] != '' 
                && $_POST['last_name'] != '' 
                && $_POST['email'] != '' 
                && $_POST['phone_number'] != '' 
                && $_POST['status'] != ''
                && $_POST['first_name'] != null 
                && $_POST['last_name'] != null 
                && $_POST['email'] != null 
                && $_POST['phone_number'] != null 
                && $_POST['status'] != null){

                $profile = new Profile();
                $profile->user_id = $user_id;
                $profile->first_name = $_POST['first_name'];
                $profile->middle_name = htmlentities($_POST['middle_name']);
                $profile->last_name = $_POST['last_name'];
                $profile->email = $_POST['email'];
                $profile->phone_number = $_POST['phone_number'];
                $profile->status = $_POST['status'];

                $profile = $profile->editProfile($user_id);

                if($profile)
                {
                    header('location:/ITspecialist/edit/' . $user_id. '?success=User Profile Was Updated.');
                } else {
                    header('location:/ITspecialist/edit/' . $user_id.'?error=Error when modifying Profile.');
                }
            }else{
                header('location:/ITspecialist/edit/' . $user_id.'?error=Please fill the required fields.');
            }
        } else { 
            $user = new User();
            $user = $user->getUserInfo($user_id);
            $this->view('ITspecialist/edit', $user);
        }
    }

    public function editUser($user_id)
    {
        if(isset($_POST['editUser']))
        {
            if($_POST['username'] !=""
                && $_POST['username'] !=null
                && $_POST['user_type'] != ""
                && $_POST['user_type'] != null
            ){
                $user = new User();
                $user->username = htmlentities($_POST['username']);
                $user->user_type = htmlentities($_POST['user_type']);
                $success;
                if($_POST['password'] != "" && $_POST['password'] != null){

                    $user->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $success = $user->editUserPassword($user_id);
                    echo "12344";
                    header('location:/ITspecialist/edit/' . $user_id . '?success=User Account Was Updated.');
                }else{
                    $user = $user->editUser($user_id);

                    if($user){
                        header('location:/ITspecialist/edit/' . $user_id. '?success=User Account Was Updated.');
                    } else {
                        header('location:/ITspecialist/edit/' . $user_id. '?error=Error when modifying User Account.');
                    }
                }
            }else{
                header('location:/ITspecialist/edit/' . $user_id.'?error=Please fill the fields to modify.');
            }
        }else{
            $user = new User();
            $user = $user->getUserInfo($user_id);
            $this->view('ITspecialist/edit', $user);
        }
    }

    // Filters
    public function search()
    {
        $user = new User();
        $users = $user->search($_GET['search']);
        $this->view('ITspecialist/index', $users);
    }
    public function allAdmins()
    {
        $user = new User();
        $users = $user->getAdmins();
        $this->view('ITspecialist/index', $users);
    }
    public function allEmployees()
    {
        $user = new User();
        $users = $user->getEmployees();
        $this->view('ITspecialist/index', $users);
    }
}