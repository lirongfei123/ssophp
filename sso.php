<?php
class Qianrong {
    private $baseUrl = 'https://login.mlife.top';
    private $authorizationURL;
    private $tokenURL;
    private $userProfileURL;
    private $ssoRedirectUrl;
    private $clientId;
    private $secret;
    public function __construct($clientId, $clientSecret, $ssoRedirectUrl) {
        $this->clientId = $clientId;
        $this->secret = $clientSecret;
        $this->ssoRedirectUrl = $ssoRedirectUrl;
        $this->authorizationURL = $this->baseUrl."/user/thirdlogin";
        $this->tokenURL = $this->baseUrl."/oauth/access_token";
        $this->userProfileURL = $this->baseUrl."/oauth/user";
    }
    public function redirectAuthUrl($redirectUrl) {
        $reurl = $this->authorizationURL."?response_type=code&redirect_uri=".urlencode($this->ssoRedirectUrl)."&state=".urlencode($redirectUrl)."&client_id=".$this->clientId;
        header("Location: ".$reurl, true, 301);
    }
    // 获取用户信息
    public function getUserInfo($code) {
        $token = $this->verifyCodeAndGetToekn($code);
        $result = $this->send($this->userProfileURL, array(
        ), array(
            "Authorization: Bearer $token"
        ), 'GET');
        return json_decode($result);
    }
    // 验证code, 并获取token
    private function verifyCodeAndGetToekn($code) {
        $result = $this->send($this->tokenURL, array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->secret,
            'code' => $code,
        ), array(
            'Content-type: application/x-www-form-urlencoded'
        ), 'POST');
        $jsonResult = json_decode($result);
        // print_r($jsonResult);
        return $jsonResult->access_token;
    }
    private function send($url, $post_data, $headers, $method) {
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => $method,
                'header' => $headers,
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
}
?>