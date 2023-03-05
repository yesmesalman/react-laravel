<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Enums\UserTypes;
use App\Helpers\Media;
use App\Models\User;
use Hash;
use Exception;

class UserController extends Controller
{
    private function genegerateOTP()
    {
        return rand(1000, 9999);
    }

    private function userAuthResponse($user, $params = [])
    {
        $token = $user->createToken('api-authentication')->accessToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => array_merge($user->getUserDisplayFields(), $params)
        ];
    }

    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6',
            ], [
                'first_name.required' => 'Please write first name',
                'last_name.required' => 'Please write last name',
                'email.email' => 'Please write email',
                'email.required' => 'Please write email',
                'email.unique' => 'Account with this email already exists',
                'password.required' => 'Please write password',
                'password.confirmed' => 'Password does not match',
                'password.min' => 'Password must be 6 characters long'
            ]);

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $input['otp'] = $this->genegerateOTP();
            $input['status'] = 1; // Account is active by default
            $input['role_id'] = UserTypes::User; // Account is type User
            $user = User::create($input);

            $response = [
                'success' => true,
                'message' => 'Acccount has been created',
                'data' => $this->userAuthResponse($user)
            ];

            return response()->json($response, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.email' => 'Please write email',
                'email.required' => 'Please write email',
                'password.required' => 'Please write password',
                'password.min' => 'Password must be 6 characters long'
            ]);

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                throw new \ErrorException('Invalid Credentials');
            }

            $user = Auth::user();

            if ($user->status == 0) {
                throw new \ErrorException('Please verify your account');
            }

            $response = [
                'success' => true,
                'message' => 'logged in',
                'data' => $this->userAuthResponse($user)
            ];

            return response()->json($response, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            $user = User::where('email', $request->email)->first();
            $otp = $this->genegerateOTP();

            if ($user == null) {
                throw new \ErrorException('User with this email does not exists');
            }

            $user->update(['otp' => $otp]);

            $response = [
                'status' => 200,
                'message' => 'Forgot password request has been sent! Please check your mail for OTP verification'
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|min:4|max:4',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:6',
            ]);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

            if ($user == null) {
                throw new \ErrorException('Invalid Email or OTP');
            }

            $user->update([
                'password' => bcrypt($request->password),
                'otp' => $this->genegerateOTP()
            ]);

            $response = [
                'status' => 200,
                'message' => 'Your password has been reset!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Revoke Token
            $res = $request->user()->token()->revoke();

            if ($res == null) {
                throw new \ErrorException('Something went wrong');
            }

            $response = [
                'status' => 200,
                'message' => "Successfully logged out"
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function editProfile(Request $request)
    {
        try {
            $user = $request->user();

            if ($request->has('first_name')) {
                $user->first_name = $request->first_name;
                $user->save();
            }

            if ($request->has('last_name')) {
                $user->last_name = $request->last_name;
                $user->save();
            }

            if ($request->has('contact_number')) {
                $user->contact_number = $request->contact_number;
                $user->save();
            }

            if ($request->has('old_password') || $request->has('password')) {
                $validator = Validator::make($request->all(), [
                    'old_password' => 'required|min:6',
                    'password' => 'required|confirmed|min:6',
                ]);

                if ($validator->fails()) {
                    throw new \ErrorException($validator->errors()->first());
                }

                if (!Hash::check($request->old_password, $user->password)) {
                    throw new \ErrorException('Old password does not match');
                }

                $user->password = bcrypt($request->password);
                $user->save();
            }

            if ($request->has('country_id')) {
                $user->country_id = $request->country_id;
                $user->save();
            }

            if ($request->has('state_id')) {
                $user->state_id = $request->state_id;
                $user->save();
            }

            if ($request->has('city_id')) {
                $user->city_id = $request->city_id;
                $user->save();
            }

            $response = [
                'status' => 200,
                'message' => "Details updated",
                'data' => [
                    'user' => $user->getUserDisplayFields()
                ]
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function uploadPicture(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'picture' => 'required|mimes:jpg,jpeg,png',
            ]);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            $user = $request->user();
            $updatedUrl = $user->profile_picture;

            if ($request->has('picture')) {
                $updatedUrl = Media::profileAvatar($request->picture);
                $user->profile_picture = $updatedUrl;
                $user->save();
            }

            $response = [
                'status' => 200,
                'message' => "",
                'data' => [
                    'profile_picture' => Media::convertFullUrl($updatedUrl)
                ]
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function getProfileDetails(Request $request)
    {
        try {
            $user = User::where('id', $request->user()->id)->with(['payments' => function ($e) {
                $e->select(['id', 'amount', 'user_id', "plan_id"])
                    ->with('plan')
                    ->select(['id', 'amount', 'user_id', "plan_id"]);
            }])->first();

            $response = [
                'status' => 200,
                'message' => "",
                'data' => [
                    'user' => array_merge($user->getUserDisplayFields(), [
                        'payments' => $user->payments
                    ])
                ]
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
