<?php
namespace Initki;

class Auth_Success extends Auth
{
    protected static function is_auth()
    {
        return true;
    }

    protected static function action()
    {
        return 'fugahoge';
    }

    protected static function brake()
    {
        return 'brake';
    }

    protected static function through()
    {
        return 'through';
    }
}

class Auth_Failure extends Auth_Success
{
    protected static function is_auth()
    {
        return false;
    }
}

/**
 * Auth class Tests
 *
 * @group Modules
 */
class Test_Auth extends \TestCase
{
    public function test_needs_auth()
    {
        // 認証済み
        $this->assertTrue(Auth_Success::check(true, array(), false));
        // 要認証・要未認証の両フラグがtrueのときは、要未認証フラグを無視
        $this->assertTrue(Auth_Success::check(true, array(), true));

        // 未認証
        $this->assertEquals('brake', Auth_Failure::check(true, array(), false));
        $this->assertEquals('brake', Auth_Failure::check(true, array('higehoge'), false));

        // 未認証だが、要認証除外actionに含まれている
        $this->assertTrue(Auth_Failure::check(true, array('higehoge', 'fugahoge'), false));
    }

    public function test_needs_unauth()
    {
        // 認証済み
        $this->assertEquals('through', Auth_Success::check(false, array(), true));

        // 未認証
        $this->assertTrue(Auth_Failure::check(false, array(), true));
    }

    public function test_check()
    {
        // 要認証でも要未認証でもないaction
        $this->assertTrue(Auth_Success::check(false, array(), false));
        $this->assertTrue(Auth_Failure::check(false, array(), false));
    }
}
