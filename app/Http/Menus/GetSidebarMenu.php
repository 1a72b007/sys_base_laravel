<?php
/*
*   07.11.2019
*   MenusMenu.php
*/
namespace App\Http\Menus;

use App\MenuBuilder\MenuBuilder;
use Illuminate\Support\Facades\DB;
use App\Models\Menus;
use App\MenuBuilder\RenderFromDatabaseData;
use App\Repositories\RolePermissionRepository;
class GetSidebarMenu implements MenuInterface{

    private $mb; //menu builder
    private $menu;

    public function __construct(){
        $this->mb = new MenuBuilder();
    }

    private function getMenuFromDB($menuId, $user_id){


        $role_permission_repo = new RolePermissionRepository;

        $permission_dropdowns = $role_permission_repo->getPermissionDropdownByUser($menuId, $user_id);
        
        $permissions_menu = $role_permission_repo->getPermissionMenusByUser($menuId, $user_id);

        $permissions_menu = $permissions_menu->merge($permission_dropdowns);

        $this->menu = $permissions_menu;

    }

    private function getGuestMenu( $menuId ){
        $this->getMenuFromDB($menuId, 'guest');
    }

    private function getUserMenu( $menuId ){
        $this->getMenuFromDB($menuId, 'user');
    }

    private function getAdminMenu( $menuId ){
        $this->getMenuFromDB($menuId, 'admin');
    }

    public function get($user_id, $menuId=2){
        $this->getMenuFromDB($menuId, $user_id);
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }

    public function getAll( $menuId=2 ){
        $this->menu = Menus::select('menus.*')
            ->where('menus.menu_id', '=', $menuId)
            ->orderBy('menus.sequence', 'asc')->get();  
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }
}
