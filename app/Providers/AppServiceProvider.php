<?php

namespace App\Providers;
use App\Models\User;
use App\Models\DynamicMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            if (Auth::check()) {
                // $menuItems = DynamicMenu::join('privilage','privilage.iFormID','=','dynamic_menus.id')->where('privilage.iUserTypeID',1)->where('dynamic_menus.show_menu',1)->where('dynamic_menus.parent_id','0')->get();
                $menuItems = DynamicMenu::where('dynamic_menus.show_menu', 1)->orderBy('parent_order', 'ASC')->get();
                view()->share('menuItems', $menuItems);

                $parentMenuItems = DynamicMenu::where('dynamic_menus.show_menu', 1)->where('dynamic_menus.parent_id', '!=', 0)->where('dynamic_menus.is_parent', 1)->orderBy('parent_order', 'ASC')->get();
                view()->share('parentMenuItems', $parentMenuItems);

                // $subMenuItems = DynamicMenu::join('privilage','privilage.iFormID','=','dynamic_menus.id')->where('privilage.iUserTypeID',1)->where('dynamic_menus.show_menu',1)->where('dynamic_menus.parent_id','!=','0')->get();
                $subMenuItems = DynamicMenu::where('dynamic_menus.show_menu', 1)->where('dynamic_menus.parent_id', '!=', '0')->where('dynamic_menus.is_parent', 0)->orderBy('child_order', 'ASC')->get();
                view()->share('subMenuItems', $subMenuItems);

                $userID = Auth::id();
                $user = User::find($userID);
              //  $roles = Role::pluck('name', 'name')->all();
              //  $userRole = $user->roles->pluck('id', 'id')->all();

                $roleID = $user->roles->first()->id;
               //var_dump($userRole);

            //    print_r($roleID);exit();

                $permissionHave =  DB::table('role_has_permissions')
                    ->select('permissions.dynamic_menu_id', 'dynamic_menus.parent_id')
                    ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                    ->join('dynamic_menus', 'permissions.dynamic_menu_id', '=', 'dynamic_menus.id')
                    ->where('role_has_permissions.role_id', $roleID)
                    ->groupBy('permissions.dynamic_menu_id')
                    ->groupBy('dynamic_menus.parent_id')
                    //->orderBy('permissions.dynamic_menu_id','ASC')
                    ->get()->toArray();

                $arrPermission = array();
                $arrParentID = array();
                foreach ($permissionHave as $per) {
                    $arrPermission[] = $per->dynamic_menu_id;
                    $arrParentID[] = $per->parent_id;
                }
                view()->share('permissionHave', $arrPermission);
                view()->share('arrParentID', $arrParentID);

            }
        });

        Gate::define('viewPulse', function (User $user) {
            return in_array($user->email,[
                'ghlakshani@gmail.com',
            ]);
        });

        Paginator::useBootstrapFive();

        require_once app_path('Helpers/CommonHelper.php');
    }
}