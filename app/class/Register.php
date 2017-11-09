<?php
namespace TaskManager;

use TaskManager\Model\User;

class Register
{
    private static $userRepo;
    private static $errors;

    public static function register($userRepo, $email, $username, $password)
    {
        self::init($userRepo);
        $user = new User($email, $username, $password);
        if(!$user->isValid()){
            self::$errors = $user->getValidationErrors();
            return false;
        }
        if(self::checkIfUserExists($email)){
            self::$errors = ["This email already exists in database"];
            return false;
        }
        self::$userRepo->persist($user);
        return true;
    }

    public static function getErrors()
    {
        return empty(self::$errors) ? false : self::$errors;
    }

    private static function init($userRepo)
    {
        self::$userRepo = $userRepo;
        self::$errors = [];
    }

    private static function checkIfUserExists($email)
    {
        return empty(self::$userRepo->findOneBy(['email'=>$email])) ? false : true;
    }
}