<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class FacebookController extends Controller
{
    public function getAccountID()
    {

        $accessToken = Auth::user()->token;
        $response = Http::get("https://graph.facebook.com/v17.0/me/accounts", [
            'fields' => 'id',
            'access_token' => $accessToken,
        ]);

        $userData = $response->json();

        return end($userData['data'])['id'];
    }

    public function getPageToken()
    {
        $accessToken = Auth::user()->token;
        $pageId = $this->getAccountID();
        $response = Http::get("https://graph.facebook.com/v17.0/{$pageId}", [
            'fields' => 'access_token',
            'access_token' => $accessToken,
        ]);
        return $response->json()['access_token'];

    }
    public function PostToPage()
    {
        $post = Post::orderBy('id', 'desc')->first();
        $pageId = $this->getAccountID();

        $accessToken = $this->getPageToken();

        $response = Http::post("https://graph.facebook.com/v17.0/{$pageId}/feed", [
            'message' => $post->name,
            "link" => $post->message,
            'access_token' => $accessToken,
        ]);
        $responseData = $response->json();

        return response()->json($responseData);
    }

    public function getPost()
    {
        $pageId = $this->getAccountID();
        $accessToken = $this->getPageToken();
        //all
        $response = Http::get("https://graph.facebook.com/v17.0/{$pageId}/posts", [
            'access_token' => $accessToken,
        ]);


        $responseData = $response->json();

        return response()->json($responseData);
    }

    public function UpdatePost($post_id)
    {


        $accessToken = $this->getPageToken();
        $response = Http::post("https://graph.facebook.com/v17.0/{$post_id}", [
            "message" => "I update  post",
            'access_token' => $accessToken,
        ]);
        $responseData = $response->json();

        return response()->json($responseData);

    }
    public function deletePost($post_id)
    {

        $accessToken = $this->getPageToken();
        $response = Http::delete("https://graph.facebook.com/v17.0/{$post_id}", [
            'access_token' => $accessToken,
        ]);
        $responseData = $response->json();

        return response()->json($responseData);
    }

    public function Test()
    {
      
    }
}
