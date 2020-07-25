<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\UserCreated;
use App\User;

class UserController extends ApiController
{
    public function __construct()
    {
        // $this->middleware('client.credentials')->only(['store', 'resend']);
        // $this->middleware('auth:api')->except(['store', 'verify', 'resend']);
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
        // $this->middleware('scope:manage-account')->only(['show', 'update']);
        // $this->middleware('can:view,user')->only('show');
        // $this->middleware('can:update,user')->only('update');
        // $this->middleware('can:delete,user')->only('destroy');
    }

    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::USUARIO_NO_VERIFICADO;
        $data['verification_token'] = User::generarVerificacionToken();
        $data['admin'] = User::USUARIO_REGULAR;

        $user = User::create($data);
        return $this->showOne($user, 201);
    }

    public function show(User $user)
    {        
        return $this->showOne($user);
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR // Que el valor este incluido en 1 de estas 2 variables
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificacionToken();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if (!$user->esVerificado()) {
                return $this->errorResponse('Just users verified can change the value', 409);
            }

            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            return $this->errorResponse('specify at least a value diferent for update', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }

    public function verify($token)
    {
       $user = User::where('verification_token', $token)->firstOrFail();
       $user->verified = User::USUARIO_VERIFICADO;
       $user->verification_token = null;
       $user->save();

       return $this->showMessage('The account has been verified succesfully ');
    }

    public function resend(User $user)
    {
        if ($user->esVerificado()) {
            return $this->errorResponse('This user is already verified', 409);
        }

        retry(5, function() use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            }, 100);

        return $this->showMessage('The verification email has been resend');
    }
}
