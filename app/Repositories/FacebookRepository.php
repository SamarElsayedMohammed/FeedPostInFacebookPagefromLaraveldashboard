<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;

use JoelButcher\Facebook\Facades\Facebook;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;

class FacebookRepository
{
    protected $facebook;

    public function __construct()
    {
        $this->facebook = new Facebook([
            'app_id' => config('providers.facebook.app_id'),
            'app_secret' => config('providers.facebook.app_secret'),
            'default_graph_version' => 'v11.0'
        ]);
    }

    public function redirectTo()
    {
        $helper = $this->facebook->getRedirectLoginHelper();

        $permissions = [
            "public_profile",
            "pages_show_list",
            "pages_read_engagement",
            "pages_manage_posts",
            "pages_manage_metadata",
            'pages_read_user_content',
            "pages_manage_posts",
        ];

        $redirectUri = "http://localhost:8000/login/facebook/callback";

        return ($helper->getLoginUrl($redirectUri, $permissions));
    }

    public function handleCallback()
    {
        $helper = $this->facebook->getRedirectLoginHelper();

        if (request('state')) {
            $helper->getPersistentDataHandler()->set('state', request('state'));
        }

        try {
            $accessToken = "EAAL2NjteQ6wBOwbcBlUCdZCuv4YeeGj46pn13r3hZA6PZCtCc4Ll5UDvpowVEZAs4ZBckxFFo5y2Eg3uCuRGzDjBESezIE7EEgyhu9pjulLeK0Hm2RONAb4ZBGXtD3sG9LA81YrukEATTYdqwdu6eJlXjDR8MM1kgnj5yljUSoG537UGlw05OPGF2OiRuxBfh8AnzFW3ituVa6xovDlF3NnFZCEsJkZD";
            // $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            throw new Exception("Graph returned an error: {$e->getMessage()}");
        } catch (FacebookSDKException $e) {
            throw new Exception("Facebook SDK returned an error: {$e->getMessage()}");
        }

        if (!isset($accessToken)) {
            throw new Exception('Access token error');
        }

        // if (!$accessToken->isLongLived()) {
        //     try {
        //         $oAuth2Client = $this->facebook->getOAuth2Client();
        //         $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        //     } catch (FacebookSDKException $e) {
        //         throw new Exception("Error getting a long-lived access token: {$e->getMessage()}");
        //     }
        // }
        return $accessToken;
        // dd($accessToken->getValue());

        //store acceess token in databese and use it to get pages
    }

    public function getUserProfile()
    {
        // dd(Auth::user());
        $accessToken = Auth::user()->token; // Replace with your access token retrieval logic

        $facebook = new Facebook([
            'app_id' => config('providers.facebook.app_id'),
            'app_secret' => config('providers.facebook.app_secret'),
            'default_graph_version' => 'v11.0'
        ]);

        try {
            $response = $facebook->get('/me?fields=id,name,email', $accessToken);
            $user = $response->getGraphUser();

            // Now you can access user data
            return $id = $user->getId();
            $name = $user->getName();
            $email = $user->getEmail();

            // Do something with the data...
        } catch (FacebookResponseException $e) {
            // Handle API response exceptions
        } catch (FacebookSDKException $e) {
            // Handle SDK exceptions
        }
    }


}
