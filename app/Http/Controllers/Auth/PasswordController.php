<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
     * @return void
     */
    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->middleware('guest');
    }

    public function getEmail()
    {
        try {
            return view('themes.default1.front.auth.password');
        } catch (\Exception $ex) {
            return redirect()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException();
        }

        return view('themes.default1.front.auth.reset')->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        //dd($request->input('token'));
        $this->validate($request, [
            'token' => 'required',
            //'email' => 'required|email',
            'password' => 'required|confirmed',
        ], [
            'token.required' => trans('validation.token_validation.token_required'),
            'password.required' => trans('validation.token_validation.password_required'),
            'password.confirmed' => trans('validation.token_validation.password_confirmed'),
        ]);
        $token = $request->input('token');
        $pass = $request->input('password');
        $password = new \App\Model\User\Password();
        $password = $password->where('token', $token)->first();
        if ($password) {
            $user = new \App\User();
            $user = $user->where('email', $password->email)->first();
            if ($user) {
                $user->password = \Hash::make($pass);
                $user->save();

                return redirect('auth/login')->with('success', trans('message.password_changed_successfully'));
            } else {
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors([
                        'email' => trans('message.invalid_email'),
                    ]);
            }
        } else {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => trans('message.invalid_email'),
                ]);
        }
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|exists:users,email'],
            [
                'email.required' => trans('validation.custom_email.required'),
                'email.email' => trans('validation.custom_email.email'),
                'email.exists' => trans('validation.custom_email.exists'),
            ]);
        $email = $request->input('email');
        $token = str_random(40);
        $password = new \App\Model\User\Password();
        if ($password->where('email', $email)->first()) {
            $token = $password->where('email', $email)->first()->token;
        } else {
            $activate = $password->create(['email' => $email, 'token' => $token]);
            $token = $activate->token;
        }

        $url = url("password/reset/$token");
        $user = new \App\User();
        $user = $user->where('email', $email)->first();
        if (! $user) {
            return redirect()->back()->with('fails', trans('message.invalid_email'));
        }
        //check in the settings
        $settings = new \App\Model\Common\Setting();
        $setting = $settings->where('id', 1)->first();
        //template
        $templates = new \App\Model\Common\Template();
        $temp_id = $setting->forgot_password;
        $template = $templates->where('id', $temp_id)->first();
        $from = $setting->email;
        $to = $user->email;
        $subject = $template->name;
        $data = $template->data;
        $replace = ['name' => $user->first_name.' '.$user->last_name, 'url' => $url];
        $type = '';
        if ($template) {
            $type_id = $template->type;
            $temp_type = new \App\Model\Common\TemplateType();
            $type = $temp_type->where('id', $type_id)->first()->name;
        }
        $mail = new \App\Http\Controllers\Common\PhpMailController();
        if ($emailSendingStatus) {
            $mail->sendEmail($from, $to, $data, $subject, $replace, $type);
        }

        return redirect()->back()->with('success', trans('message.resets_instruction').$to.'. '.trans('message.check_junk_folder'));
    }
}
