<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Academic\AcademicSession;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\UserRepository;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\Auth\PasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Repositories\Configuration\ConfigurationRepository;

class AuthController extends Controller
{
    protected $request;
    protected $repo;
    protected $user;
    protected $config;
    protected $academic_session;
    protected $module = 'user';

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Request $request,
        AuthRepository $repo,
        UserRepository $user,
        ConfigurationRepository $config,
        AcademicSession $academic_session
    ) {
        $this->request = $request;
        $this->repo = $repo;
        $this->user = $user;
        
        $this->middleware('prohibited.test.mode')->only('changePassword');
        $this->config = $config;
        $this->academic_session = $academic_session;
    }

    /**
     * Used to authenticate user
     * @post ("/api/auth/login")
     * @param ({
     *      @Parameter("email_or_username", type="string", required="true", description="Email or Username of User"),
     *      @Parameter("password", type="password", required="true", description="Password of User"),
     * })
     * @return authentication token
     */
    public function authenticate(LoginRequest $request)
    {
        $auth = $this->repo->auth($this->request->all());

        $auth_user                   = $auth['auth_user'];
        $token                       = $auth['token'];
        $auth_user->user_roles       = $auth_user->roles()->pluck('name')->all();
        $auth_user->user_permissions = $auth_user->getAllPermissions()->pluck('name')->all();

        \Cache::put('locale', $auth_user->userPreference->locale, config('jwt.ttl'));
        \Cache::put('direction', $auth_user->userPreference->direction, config('jwt.ttl'));

        $reload = (config('app.locale') != cache('locale') || config('config.direction') != cache('direction')) ? 1 : 0;

        $config            = $this->config->getConfig();
        $academic_sessions = $this->academic_session->all();
        $default_academic_session = $auth_user->userPreference->academic_session_id ? $auth_user->userPreference->academicSession : $academic_sessions->firstWhere('is_default',1);

        activity('login')->log('login');

        return $this->success([
            'message'           => trans('auth.logged_in'),
            'token'             => $token,
            'user'              => $auth_user,
            'reload'            => $reload,
            'config'            => $config,
            'academic_sessions' => $academic_sessions,
            'default_academic_session' => $default_academic_session
        ]);
    }

    /**
     * Used to logout user
     * @post ("/api/auth/logout")
     * @return Response
     */
    public function logout()
    {
        $auth_user = \Auth::user();

        try {
            $token = JWTAuth::getToken();
        } catch (JWTException $e) {
            return $this->error($e->getMessage());
        }

        \Cache::forget('direction');
        \Cache::forget('locale');

        activity('logout')->log('logout');
        
        JWTAuth::invalidate($token);

        $config = $this->config->getConfig();
        return $this->success(['message' => trans('auth.logged_out'), 'config' => $config]);
    }

    /**
     * Used to request password reset token for user
     * @post ("/api/auth/password")
     * @param ({
     *      @Parameter("email", type="email", required="true", description="Registered Email of User"),
     * })
     * @return Response
     */
    public function password(PasswordRequest $request)
    {
        $this->repo->password($this->request->all());

        return $this->success(['message' => trans('passwords.sent')]);
    }

    /**
     * Used to validate user password
     * @post ("/api/auth/validate-password-reset")
     * @param ({
     *      @Parameter("token", type="string", required="true", description="Reset Password Token"),
     * })
     * @return Response
     */
    public function validatePasswordReset()
    {
        $this->repo->validateResetPasswordToken(request('token'));

        return $this->success(['message' => '']);
    }

    /**
     * Used to reset user password
     * @post ("/api/auth/reset")
     * @param ({
     *      @Parameter("token", type="string", required="true", description="Reset Password Token"),
     *      @Parameter("email", type="email", required="true", description="Email of User"),
     *      @Parameter("password", type="password", required="true", description="New Password of User"),
     *      @Parameter("password_confirmation", type="password", required="true", description="New Confirm Password of User"),
     * })
     * @return Response
     */
    public function reset(ResetPasswordRequest $request)
    {
        $this->repo->reset($this->request->all());

        return $this->success(['message' => trans('passwords.reset')]);
    }

    /**
     * Used to change user password
     * @post ("/api/change-password")
     * @param ({
     *      @Parameter("current_password", type="password", required="true", description="Current Password of User"),
     *      @Parameter("new_password", type="password", required="true", description="New Password of User"),
     *      @Parameter("new_password_confirmation", type="password", required="true", description="New Confirm Password of User"),
     * })
     * @return Response
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $this->repo->validateCurrentPassword(request('current_password'));

        $this->repo->resetPassword(request('new_password'));

        return $this->success(['message' => trans('passwords.change')]);
    }

    /**
     * Used to verify password during Screen Lock
     * @post ("/api/auth/lock")
     * @param ({
     *      @Parameter("password", type="password", required="true", description="Password of User"),
     * })
     * @return Response
     */
    public function lock(LoginRequest $request)
    {
        $this->repo->validateCurrentPassword(request('password'));

        return $this->success(['message' => trans('auth.lock_screen_verified')]);
    }
}
