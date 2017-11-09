<?php 
namespace TaskManager;

class CsrfGuard
{
    private static $session;

    public static function generateToken($uniqueFormName)
	{
	    self::init();
		$token = bin2hex(random_bytes(16));
		self::$session->put($uniqueFormName,$token);
		return $token;
	}

	public static function validateToken($unique_form_name,$token_value)
	{
        self::init();
		$token = self::$session->get($unique_form_name);
		if (!is_string($token_value)){
			return false;
		}
		$result = hash_equals($token, $token_value);
        self::$session->delete($unique_form_name);
		return $result;
	}

	private function init()
    {
        self::$session = new Session();
    }
}