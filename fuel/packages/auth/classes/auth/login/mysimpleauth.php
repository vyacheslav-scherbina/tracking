<?php

namespace Auth;

class Auth_Login_MySimpleAuth extends Auth_Login_SimpleAuth
{
     /*  required fields : 
             username
             password 
             group 
             first_name 
             last_name 
     */
    
    public function create_person($fields)
	{
		$fields['username'] = filter_var(trim($fields['username']), FILTER_VALIDATE_EMAIL);

        if (empty($fields['username']))
		{
			throw new \SimpleUserUpdateException('Username is either empty or incorrect');
		}
        
		if (empty($fields['password']))
		{
			throw new \SimpleUserUpdateException('Password cannot be empty');
		}

        $same_persons = \Model_Person::find()->where('username', $fields['username'])->get();
        
		if ( ! empty($same_persons))
		{
			throw new \SimpleUserUpdateException('Person already exists');
		}
		
		$fields['password'] = $this->hash_password($fields['password']);
		
        $result = \Model_Person::forge($fields)->save();
		return $result;
	}
    
    public function login($username = '', $password = '')
	{
		$username = trim($username) ?: trim(\Input::post(\Config::get('simpleauth.username_post_key', 'username')));
		$password = trim($password) ?: trim(\Input::post(\Config::get('simpleauth.password_post_key', 'password')));

		if (empty($username) or empty($password))
		{
			return false;
		}

		$password = $this->hash_password($password);
		$this->user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
			->where('username', '=', $username)
			->where('password', '=', $password)
			->from(\Config::get('simpleauth.table_name'))
			->execute(\Config::get('simpleauth.db_connection'))->current();

		if ($this->user == false)
		{
			$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
			\Session::delete('username');
			\Session::delete('login_hash');
			return false;
		}
		\Session::set('username', $this->user['username']);
		\Session::set('login_hash', $this->create_login_hash());
		\Session::instance()->rotate();
		return true;
	}
    
    public function get_user($key = null)
    {
        if (is_null($key))
            return $this->user;
        else
            return $this->user[$key];
    }
    
    
}
