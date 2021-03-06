<?php


namespace app\core;


use app\core\exceptions\HttpException;

class Session
{
    protected const FLASH_KEY = "flash_messages";
    public static Session $instance;
    public static function getInstance()
    {
        if(!isset(self::$instance)){
            self::$instance = new Session();
        }
        return self::$instance;
    }


    protected function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->markFlashMessagesAsRemoved();
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }


    public function hasFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }


    private function markFlashMessagesAsRemoved()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            if (is_array($flashMessage)) {
                $flashMessage["remove"] = true;
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * @return mixed
     */
    private function removeFlashMessages()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }

        throw new HttpException('There is no such key in the session');
    }

    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $this->removeFlashMessages();
    }
}