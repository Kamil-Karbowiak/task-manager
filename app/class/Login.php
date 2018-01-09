<?php
namespace TaskManager;

use TaskManager\Model\User;
use TaskManager\Repository\EntityRepository;

class Login
{
    private static $session;
    private static $errors;
    private static $userRepo;

    public static function login($userRepo, $email, $password)
    {
        self::init($userRepo);
        $user = self::getUser($email);
        if(!$user || !self::isPasswordCorrect($password, $user->getPasswordHash())){
            self::$errors = ['The username and password you entered did not match our records. Please double-check and try again.'];
            return false;
        }
        self::saveCredentialsInSession($user);
        self::changeSessionId();
        return true;
    }

    public static function logout()
    {
        self::init();
        self::$session->delete('userId');
        self::$session->delete('userName');
        self::$session->destroy();
    }

    public static function isLoggedIn()
    {
        self::init();
        return self::$session->exists('userId');
    }

    public static function getErrors()
    {
        return !empty(self::$errors) ? self::$errors : false;
    }

    private static function init(EntityRepository $userRepo = null)
    {
        self::$session = new Session();
        self::$errors = [];
        self::$userRepo = $userRepo;
    }

    private static function getUser($email)
    {
        return self::$userRepo->findOneBy(['email'=>$email]);
    }

    private static function isPasswordCorrect($password, $passwordHash)
    {
        return password_verify($password, $passwordHash);
    }

    private static function changeSessionId()
    {
        session_regenerate_id(true);
    }

    private static function saveCredentialsInSession(User $user)
    {
        self::$session->put('userId', $user->getid());
        self::$session->put('userName', $user->getName());
    }
}
