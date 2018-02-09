<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Contact;
use App\User;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('user_id')->references('id')->on('user');
            $table->string('first_name')->nullable()->default(NULL);
            $table->string('last_name')->nullable()->default(NULL);
            $table->string('organization')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->string('phone')->nullable()->default(NULL);
            $table->timestamps();
        });

        foreach (User::all() as $user) {
            $contact = Contact::create([
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->profile ? $user->profile->phone : null,
                'organization' => $user->profile ? $user->profile->current_organization : null,
                'title' => $user->profile ? $user->profile->current_title : null
            ]);
        }

        DB::table('resource')->insert(
            array(
                'code' => 'contact_create',
                'description' => "Can create a contact."
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'contact_show',
                'description' => "Can view any contact"
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'contact_edit',
                'description' => "Can edit any contact"
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_edit',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_edit',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_show',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_create',
                'role_code' => 'administrator'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('resource_role')->where('resource_code', 'contact_create')->delete();
        DB::table('resource_role')->where('resource_code', 'contact_show')->delete();
        DB::table('resource_role')->where('resource_code', 'contact_edit')->delete();
        DB::table('resource')->where('code', 'contact_create')->delete();
        DB::table('resource')->where('code', 'contact_show')->delete();
        DB::table('resource')->where('code', 'contact_edit')->delete();

        Schema::dropIfExists('contact');
    }
}
