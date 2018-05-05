<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Models\Module;
use App\Http\Models\Company;
use App\Http\Models\Role;
use App\Http\Models\Resource;
class RolesPermisosModulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['active','inactive'])->default('active');
        });
        Schema::create('module', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
            $table->integer('order')->nullable();
            $table->string('icon')->nullable();
            $table->integer('father_id')->default('0');
            $table->timestamps();
        });
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->enum('status', ['active','inactive'])->default('active');
            $table->timestamps();
        });
        Schema::create('role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('resource', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('module_id');
            $table->timestamps();
            $table->foreign('module_id')->references('id')->on('module');
        });
        Schema::create('role_company_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('company_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('role');
            $table->foreign('company_id')->references('id')->on('company');
        });
        Schema::create('permission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_company_users_id');
            $table->unsignedInteger('resource_id');
            $table->timestamps();
            $table->foreign('role_company_users_id')->references('id')->on('role_company_users');
            $table->foreign('resource_id')->references('id')->on('resource');
        });
        DB::table('company')->insert([
                'name' => 'Soluciones S.A.',
                'description' => 'Empresa Soluciones S.A.',
                'status' => 'active'
            ]
        );
        DB::table('role')->insert([
                'name' => 'admin',
                'description' => 'Administrador del Sistema'
            ]
        );
        DB::table('module')->insert([
                'name' => 'Administracion',
                'description' => 'Rol con Acceso a todo el sistema.',
                'status' => 'active',
                'order' => '1',
                'icon' => 'fa fa-cog'
            ]
        );
        DB::table('resource')->insert([
                'name' => 'list',
                'module_id' => '1'
            ]
        );
        DB::table('resource')->insert([
                'name' => 'create',
                'module_id' => '1'
            ]
        );
        DB::table('resource')->insert([
                'name' => 'view',
                'module_id' => '1'
            ]
        );        
        DB::table('resource')->insert([
                'name' => 'edit',
                'module_id' => '1'
            ]
        );
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module');
        Schema::dropIfExists('company');
        Schema::dropIfExists('role');
        Schema::dropIfExists('resource');
        Schema::dropIfExists('role_company_users');
        Schema::dropIfExists('permission');
    }
}