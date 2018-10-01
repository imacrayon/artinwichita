<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Contracts\Factory as Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Socialite $social)
    {
        $this->middleware('guest')->except('logout');

        $this->social = $social;
    }

    /**
     * Redirect the user to the provider's authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return $this->social->driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $profile = $this->social->driver($provider)->user();
        } catch (\Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        return empty($profile->email)
            ? $this->sendFailedResponse('No email returned from ' . ucwords($provider) . ' provider.')
            : $this->loginOrCreateAccount($profile, $provider);
    }

    /**
     * Send a successful response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendSuccessResponse()
    {
        return redirect()->intended($this->redirectTo);
    }

    /**
     * Send a failed response with a msg
     *
     * @param null $msg
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedResponse($message = null)
    {
        return redirect()->route('login')
            ->withErrors(['social' => $message ?: 'Unable to login, try another login method.']);
    }

    /**
     * Login or create a new user account
     *
     * @param $profile
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginOrCreateAccount($profile, $provider)
    {
        $user = User::where("settings->{$provider}_id", $profile->getId())->first();

        if (! $user) {
            $user = User::where('email', $profile->getEmail())->first();
        }

        if (! $user) {
            $user = User::create([
                'name' => $profile->getName(),
                'email' => $profile->getEmail()
            ]);
        }

        $user->update([
            'settings' => [
                "{$provider}_id" => $profile->getId(),
                "{$provider}_token" => $profile->token,
                'expires_at' => Carbon::now()
                                    ->addSeconds($profile->expiresIn)
                                    ->format('Y-m-d H:i:s')
            ]
        ]);

        Auth::login($user, true);

        return $this->sendSuccessResponse();
    }
}
