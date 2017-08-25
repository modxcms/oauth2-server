<?php

use OAuth2\Storage\UserCredentialsInterface;

class OAuth2ServerUserStorage implements UserCredentialsInterface {
	
	public $modx;
	
	function __construct(MODx &$modx){
		$this->modx = $modx;
	}
	
    /**
     * Grant access tokens for basic user credentials.
     *
     * Check the supplied username and password for validity.
     *
     * You can also use the $client_id param to do any checks required based
     * on a client, if you need that.
     *
     * Required for OAuth2::GRANT_TYPE_USER_CREDENTIALS.
     *
     * @param $username
     * Username to be check with.
     * @param $password
     * Password to be check with.
     *
     * @return
     * TRUE if the username and password are valid, and FALSE if it isn't.
     * Moreover, if the username and password are valid, and you want to
     *
     * @see http://tools.ietf.org/html/rfc6749#section-4.3
     *
     * @ingroup oauth2_section_4
     */
    public function checkUserCredentials($username, $password){
		
        $response = $this->runLoginProcessor($username, $password);
        
        /* if we've got a good response, proceed */
        return (!empty($response) && !$response->isError());
    	
    }
	
    /**
     * @return modProcessorResponse
     */
    public function runLoginProcessor($username, $password) {
        /* send to login processor and handle response */
        $properties = array(
            'login_context' => $this->modx->getOption('oauth2server_login_context',null,'web'),
            'add_contexts'  => '',
            'username'      => $username,
            'password'      => $password,
            'returnUrl'     => '',
            'rememberme'    => ''
        );
        
		return $this->modx->runProcessor('security/login', $properties);
    }
	

    /**
     * @return
     * ARRAY the associated "user_id" and optional "scope" values
     * This function MUST return FALSE if the requested user does not exist or is
     * invalid. "scope" is a space-separated list of restricted scopes.
     * @code
     * return array(
     *     "user_id"  => USER_ID,    // REQUIRED user_id to be stored with the authorization code or access token
     *     "scope"    => SCOPE       // OPTIONAL space-separated list of restricted scopes
     * );
     * @endcode
     */
    public function getUserDetails($username){
		$user = $this->modx->getObject('modUser',array('username'=>$username));
		return !empty($user) ? array('user_id'=>$user->get('id')) : false;
    }
}