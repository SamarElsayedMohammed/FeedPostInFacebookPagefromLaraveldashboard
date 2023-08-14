<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function redirectToFacebookProvider()
    {

        return (Socialite::driver('facebook')->scopes([

            "email",
            "manage_fundraisers",
            "read_insights",
            "publish_video",
            "catalog_management",
            "pages_manage_cta",
            "pages_manage_instant_articles",
            "pages_show_list",
            "read_page_mailboxes",
            "ads_management",
            "ads_read",
            "business_management",
            "pages_messaging",
            "pages_messaging_subscriptions",
            "instagram_basic",
            "instagram_manage_comments",
            "instagram_manage_insights",
            "instagram_content_publish",
            "leads_retrieval",
            "whatsapp_business_management",
            "instagram_manage_messages",
            "page_events",
            "pages_read_engagement",
            "pages_manage_metadata",
            "pages_read_user_content",
            "pages_manage_ads",
            "pages_manage_posts",
            "pages_manage_engagement",
            "whatsapp_business_messaging",
            "instagram_shopping_tag_products",


        ])->redirect());

    }

    public function ProviderCallBack($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();
        if ($users) {
            Auth::login($users);
            return redirect('/');
        } else {
            $userDTO = new UserDTO(
                $userSocial->getName(),
                $userSocial->getEmail(),
                '123',
                $userSocial->token ?? '',
                $userSocial->getAvatar(),
                $userSocial->getId(),
                $userSocial->getId(),
                $provider,
            );
            $user = $this->userService->createUser($userDTO);
            return redirect()->route('dashboard');
        }
    }

}
