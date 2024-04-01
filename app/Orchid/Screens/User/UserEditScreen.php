<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Models\Role;
use App\Orchid\Layouts\Role\RolePermissionLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use App\Orchid\Layouts\User\UserRoleLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Orchid\Access\Impersonation;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Dashboard;
class UserEditScreen extends Screen
{
    /**
     * @var User
     */
    public $user;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(User $user): iterable
    {
        $user->load(['roles']);

        return [
            'user'       => $user,
            'permission' => $user->getStatusPermission(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->user->exists ? 'Edit User' : 'Create User';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'User profile and privileges, including their associated role.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Impersonate user'))
                ->icon('bg.box-arrow-in-right')
                ->confirm(__('You can revert to your original state by logging out.'))
                ->method('loginAs')
                ->canSee($this->user->exists && $this->user->id !== \request()->user()->id),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->user->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::block(UserEditLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Update your account\'s profile information and email address.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

            Layout::block(UserPasswordLayout::class)
                ->title(__('Password'))
                ->description(__('Ensure your account is using a long, random password to stay secure.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

            Layout::block(UserRoleLayout::class)
                ->title(__('Roles'))
                ->description(__('A Role defines a set of tasks a user assigned the role is allowed to perform.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

            Layout::block(RolePermissionLayout::class)
                ->title(__('Permissions'))
                ->description(__('Allow the user to perform some actions that are not provided for by his roles'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(User $user, Request $request)
    {
        $authUser = Auth::user();
        // Check if the user is authorized to edit users
       if (!Auth::user()->hasAccess('platform.systems.users')) {
            Toast::error(__('You are not authorized to perform this action.'));
            return redirect()->back();
        }

        // Check if the user is trying to edit their own profile
        if ($user->id === Auth::id()) {
            // Prevent editing permissions or roles for own profile
            Toast::error(__('You are not allowed to change your own permissions or roles.'));
            return redirect()->back();
        }

        // Check if the authenticated user has the permission to grant the specified permissions
        $allowedPermissions = Auth::user()->permissions ?? [];


        $permissions = $request->get('permissions', []);
        $requestedPermission = [];

        $decodedPermissions = collect($permissions)->map(function ($value, $key) {
            // Decode the key (permission) if it's not empty
            $decodedKey = $key ? base64_decode($key) : $key;

            // Check if the permission was selected or not

            return [$decodedKey => $value];
        });

        $extractedPermissions = [];

        foreach ($decodedPermissions as $permissions) {
            foreach ($permissions as $key => $value) {
                $extractedPermissions[$key] = $value;
            }
        }
        $invalidPermissions = [];
       //d($extractedPermissions) ;
        foreach ($extractedPermissions as $key => $value) {
            // Check if the value is "1" in extractedPermissions and "0" in allowedPermissions
            if ($value === "1" && ($allowedPermissions[$key] ?? null) === "0") {
                $invalidPermissions[$key] = $value;
            }
        }
        //dd($extractedPermissions, $allowedPermissions, $invalidPermissions);
        $invalidPermissions = collect($invalidPermissions);
        if ($invalidPermissions->isNotEmpty()) {
            // Prevent the user from granting permissions that they do not have
            Toast::error(__('You are not allowed to grant permissions that you do not have.'));
            return redirect()->back();
        }

        if ($authUser->roles()->exists()) {
            // Retrieve the highest authority role of the authenticated user
            $highestAuthorityRole = $authUser->roles()->orderByDesc('authority')->first();
            foreach ($request->input('user.roles', []) as $roleId) {
                $role = Role::findOrFail($roleId);

                if ($role->authority >= $highestAuthorityRole->authority) {
                    Toast::error(__('You are not allowed to assign or remove roles of equal or higher authority than your own.'));
                    return redirect()->back();
                }
            }
        } else {
            // If the authenticated user has no roles, prevent them from assigning any roles
            Toast::error(__('You do not have any roles assigned and cannot assign roles to other users.'));
            return redirect()->back();
        }

            // Validate the request data
        $request->validate([
            'user.email' => [
                'required',
                Rule::unique(User::class, 'email')->ignore($user),
            ],
            'user.forename' => 'required', // Add validation for forename
            'user.surname' => 'required',
        ]);

        // Update the user's name based on forename and surname
        $user->surname = $request->input('user.surname');
        $user->forename = $request->input('user.forename');
        $user->name = $request->input('user.forename') . ' ' . $request->input('user.surname');
        $user->email = $request->input('user.email');
        // Update the password if provided
        if ($request->filled('user.password')) {
            $user->password = Hash::make($request->input('user.password'));
        }
        //dd($user);
        // Save the user details
        $user->save();

        // Update user permissions
        $permissions = collect($request->get('permissions'))
            ->map(fn ($value, $key) => [base64_decode($key) => $value])
            ->collapse()
            ->toArray();

        $user->forceFill(['permissions' => $permissions])->save();

        // Update user roles
        $user->replaceRoles($request->input('user.roles'));

        // Show success message
        Toast::info(__('User details have been saved.'));

        return redirect()->route('platform.systems.users');
    }
    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        $user->delete();

        Toast::info(__('User was removed'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->canImpersonate()) {
            Impersonation::loginAs($user);

            Toast::info(__('You are now impersonating this user'));

            return redirect()->route(config('platform.index'));
        } else {
            // Redirect the user or show an error message indicating they don't have permission
            return redirect()->back()->with('error', __('You do not have permission to impersonate users'));
        }
    }
}
