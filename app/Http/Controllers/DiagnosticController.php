<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DiagnosticController extends Controller
{
    public function admin(Request $request)
    {
        $token = $request->query('token');
        if ($token !== config('app.key')) {
            return response()->json(['error' => 'invalid_token'], 403);
        }

        $admin = User::where('role', 'admin')->first();

        if (! $admin) {
            return response()->json([
                'found' => false,
                'error' => 'no_admin_user',
                'env'   => app()->environment(),
                'debug' => config('app.debug'),
            ]);
        }

        return response()->json([
            'found'              => true,
            'id'                 => $admin->id,
            'name'               => $admin->name,
            'email'              => $admin->email,
            'role'               => $admin->role,
            'password_hash_prefix' => substr($admin->password, 0, 30),
            'updated_at'         => $admin->updated_at?->toIso8601String(),
            'created_at'         => $admin->created_at?->toIso8601String(),
            'env'                => app()->environment(),
            'app_url'            => config('app.url'),
            'db_connection'      => config('database.default'),
            'php_version'        => PHP_VERSION,
            'laravel_version'    => app()->version(),
        ]);
    }

    public function testPassword(Request $request)
    {
        $token = $request->query('token');
        if ($token !== config('app.key')) {
            return response()->json(['error' => 'invalid_token'], 403);
        }

        $password = $request->query('password');
        $admin = User::where('role', 'admin')->first();

        if (! $admin) {
            return response()->json(['found' => false, 'matches' => false]);
        }

        $matches = Hash::check($password, $admin->password);

        return response()->json([
            'found'   => true,
            'matches' => $matches,
            'hash_algo' => password_get_info($admin->password)['algoName'] ?? 'unknown',
        ]);
    }

    /**
     * POST /__diag/admin/reset?token=XXX&password=YYY
     * ONE-SHOT endpoint to reset admin password. Will be removed after recovery.
     */
    public function resetPassword(Request $request)
    {
        $token = $request->query('token');
        if ($token !== config('app.key')) {
            return response()->json(['error' => 'invalid_token'], 403);
        }

        $password = $request->query('password');
        if (! $password || strlen($password) < 8) {
            return response()->json(['error' => 'password_too_short', 'min' => 8], 422);
        }

        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            // Create one if missing
            $admin = User::create([
                'name'              => 'Admin Temanten',
                'email'             => 'admin@temanten.test',
                'password'          => Hash::make($password),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]);
            return response()->json([
                'created' => true,
                'email'   => $admin->email,
                'note'    => 'no admin found, created new one',
            ]);
        }

        $admin->password = Hash::make($password);
        $admin->save();

        return response()->json([
            'reset' => true,
            'email' => $admin->email,
            'hash'  => substr($admin->password, 0, 30),
        ]);
    }
}
