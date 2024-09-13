<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\Permission;

class AddBundleSubscriptionPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Permission::find(347)) {
            $sql = [
                ['id' => 347, 'module_id' => 347, 'parent_id' => null, 'name' => 'BundleSubscription', 'route' => 'bundle.subscription', 'type' => 1],

                ['id' => 348, 'module_id' => 347, 'parent_id' => 347, 'name' => 'Bundle  status', 'route' => 'change.status', 'type' => 2],

                ['id' => 349, 'module_id' => 347, 'parent_id' => 347, 'name' => 'Bundle  List', 'route' => 'bundle.course', 'type' => 2],
                ['id' => 350, 'module_id' => 347, 'parent_id' => 349, 'name' => 'Bundle Store', 'route' => 'bundle.store', 'type' => 3],
                ['id' => 351, 'module_id' => 347, 'parent_id' => 349, 'name' => 'Bundle Edit', 'route' => 'bundle.update', 'type' => 3],

                ['id' => 352, 'module_id' => 347, 'parent_id' => 347, 'name' => 'Bundle Course List', 'route' => 'course.index', 'type' => 2],
                ['id' => 353, 'module_id' => 347, 'parent_id' => 352, 'name' => 'Bundle Course Store', 'route' => 'course.store', 'type' => 3],
                ['id' => 354, 'module_id' => 347, 'parent_id' => 352, 'name' => 'Bundle Course Delete', 'route' => 'bundle.course.delete', 'type' => 3],
            ];
            DB::table('permissions')->insert($sql);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
