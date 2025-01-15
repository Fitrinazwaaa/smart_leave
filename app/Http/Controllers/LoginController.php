<?php 
namespace App\Http\Controllers;

use App\Models\User;  // Assuming you are using the default User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('login');  // Make sure the login view exists
    }

    // Login for User
    public function login(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'userId' => 'required|string',
            'password' => 'required|string',
        ]);
        
        // Find the user from the users table
        $user = User::where('username', $request->userId)->first();  // Find user by username
        
        if (!$user) {
            return back()->withErrors(['userId' => 'User not found']);
        }
        
        // Check if the password matches
        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);  // Log the user in
    
            // Redirect based on role
            if ($user->role == 'siswa') {
                return redirect()->route('dashboardSiswa');  // Redirect to Siswa dashboard
            } elseif ($user->role == 'guru') {
                return redirect()->route('dashboardGuru');  // Redirect to Guru dashboard
            }
        }
    
        // If login failed
        return back()->withErrors(['password' => 'Incorrect password']);
    }
    

    // Logout function
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');  // Redirect to login page
    }
}
