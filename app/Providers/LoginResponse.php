namespace App\Providers;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Redirect admins to the admin dashboard
        if ($request->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Redirect regular users to the default dashboard
        return redirect()->route('dashboard');
    }
}
