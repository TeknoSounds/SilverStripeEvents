<?php

class LoginPage extends Page {

}

class LoginPage_Controller extends Page_Controller {

	public function LoginForm() {
		$form = new Form (
			$this,
			"LoginForm",
			new FieldSet (
				new TextField('Username'),
				new PasswordField('Password')
			),
			new FieldSet (
				new FormAction('authenticate', 'Login')
			),
			new RequiredFields('Username', 'Password')
		);
		return $form;
	}
	
	public function authenticate($data, $form) {
		$user = DataObject::get_one('User', "`Name` = '{$data['Username']}'");
		if ($user && $user->Password == md5($data['Password'])){
			Session::set('username', $data['Username']);
			Director::redirect(Director::baseURL(). 'fb-quick');
			return;
		}
		Director::redirect(Director::baseURL(). $this->URLSegment . "/?failure=1");
		return;
	}
	
	public function createuser($request){
		$form = self::CreateUserForm();
		$data = array(
			$this,
			"LoginForm" => $form
		);
		return $this->customise($data)->renderWith(array('LoginPage', 'Page'));
	}
	
	public function CreateUserForm(){
		$form = new Form (
			$this,
			"CreateUserForm",
			new FieldSet (
				new TextField('Username'),
				new TextField('Email'),
				new PasswordField('Password'),
				$recaptchaField = new RecaptchaField('MyCaptcha')
			),
			new FieldSet (
				new FormAction('doCreateUser', 'Create Account')
			),
			new RequiredFields('Username', 'Password')
		);
		return $form;
	}
	
	public function doCreateUser($data, $form) {
		$user = new User();
		$userExists = DataObject::get_one('User', "`Name` = '{$data['Username']}'");
		if (!$userExists){
			$user->Name = $data['Username'];
			$user->Email = $data['Email'];
			$user->Password = md5($data['Password']);
			$user->CanFBPost = true;
			$user->write();
			Director::redirect(Director::baseURL(). "login/?created=1");
			return;
		}
		Director::redirect(Director::baseURL(). $this->URLSegment . "/?duplicate=1");
	}
	
	public function logoff($request){
		Session::set('username', '');
		Director::redirect(Director::baseURL());
	}

	
	
	public function Failed() {
		return isset($_REQUEST['failure']) && $_REQUEST['failure'] == "1";
	}
	
	public function CreatingUser() {
		$URLParams = Director::urlParams(); ;
		return (strlen($URLParams['ID']) > 0);
	}
	
	public function UserCreated() {
		return isset($_REQUEST['created']) && $_REQUEST['created'] == "1";
	}
	
	public function DuplicateUser() {
		return isset($_REQUEST['duplicate']) && $_REQUEST['duplicate'] == "1";
	}
}
