<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * DIAGNOSTIC ONLY — exposes admin user state for remote verification.
 * Will be deleted after password reset is confirmed.
 *
 * Access: GET /__diag/admin
 * Returns: { id, email, role, password_hash_prefix, created_at, updated_at, env, app_debug }
 */
class DiagnosticController extends Controller
{
    public function admin(Request $request)
    {
        // Token check — only allow from our server with a shared secret
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

    /**
     * Test if a given password matches the admin hash.
     * GET /__diag/admin/test?token=XXX&password=YYY
     */
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
}
