<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\OwnerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_type' => ['required', 'string', 'in:student,hostel-owner'],
        ];

        if ($request->role_type === 'hostel-owner') {
            $rules['hostel_name'] = ['required', 'string', 'max:255'];
            $rules['address'] = ['required', 'string'];
        }

        $request->validate($rules);

        $role = Role::where('slug', $request->role_type)->first();
        if (!$role) {
            throw ValidationException::withMessages([
                'role_type' => 'The selected role type is invalid.',
            ]);
        }

        $status = $request->role_type === 'student' ? 'approved' : 'pending';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'status' => $status,
        ]);
        
        $user->assignRole($role);

        if ($request->role_type === 'hostel-owner') {
            OwnerProfile::create([
                'user_id' => $user->id,
                'hostel_name' => $request->hostel_name,
                'address' => $request->address,
                'city' => 'Kota',
                'state' => 'Rajasthan',
                'status' => 'pending',
            ]);

            event(new Registered($user));

            return redirect()->route('login')->with('status', 'Your registration is submitted and pending admin approval. You will be notified via email once approved.');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
