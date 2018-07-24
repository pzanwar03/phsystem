<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class AccountController extends Controller {

    public function index() {
        //
    }

    public function loginAction(Request $request) {
        $response = [];
        $validator = Validator::make($request->all(), [
                    'email' => 'required|exists:users,email',
                    'password' => 'required',
                        ], [
                    'email.required' => '<p>Email field is required.</p>',
                    'password.required' => '<p>Password field is required.</p>'
        ]);

        if ($validator->fails()) {
            $response['status'] = 'error';
            $message = $validator->errors()->all();
            $response['msg'] = $message;
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                $result = array('msg' => 'success');
                $response['status'] = 'success';
                $response['msg'] = 'You have successfully!!';
                $response['url'] = url('/');
            } else {
                $response['status'] = 'error';
                $response['msg'] = 'Email and password not match!!';
            }
        }
        echo json_encode($response);
    }

}
