<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Address;
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
            $table->string('email')->unique()->nullable()->default(NULL);
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

        Schema::create('address_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('address_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('address_id')->references('id')->on('address');
            $table->integer('profile_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('profile_id')->references('id')->on('profile');
            $table->timestamps();
        });

        Schema::create('address_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('address_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('address_id')->references('id')->on('address');
            $table->integer('contact_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('contact_id')->references('id')->on('contact');
            $table->timestamps();
        });

        DB::insert("INSERT INTO `address_profile` (`address_id`, `profile_id`) SELECT `a`.`id`, `p`.`id` FROM `address` AS `a` JOIN `user` AS `u` ON `a`.`user_id`=`u`.`id` JOIN `profile` AS `p` ON `u`.`id`=`p`.`user_id`;");

        foreach (Address::all() as $address) {
            $address = Address::create([
                'name' => $address->name,
                'line1' => $address->line1,
                'line2' => $address->line2,
                'city' => $address->city,
                'state' => $address->state,
                'postal_code' => $address->postal_code,
                'country' => $address->country,
                'user_id' => $address->user_id
            ]);
            DB::insert("INSERT INTO `address_contact` (`address_id`, `contact_id`) SELECT `a`.`id`, `c`.`id` FROM `address` AS `a` JOIN `user` AS `u` ON `a`.`user_id`=`u`.`id` JOIN `contact` AS `c` ON `c`.`user_id`=`u`.`id` WHERE `a`.`id`=".$address->id.";");
        }

        Schema::table('address', function (Blueprint $table) {
            $table->dropForeign([
                'user_id',
            ]);
            $table->dropColumn([
                'user_id',
            ]);
        });

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
                'role_code' => 'superuser'
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

        Schema::table('address_contact', function (Blueprint $table) {
            $table->dropForeign([
                'address_id',
            ]);
        });

        DB::table('address')
            ->join('address_contact', 'address.id', '=', 'address_contact.address_id')
            ->delete();

        Schema::dropIfExists('address_contact');

        Schema::table('address', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
        });

        DB::update("UPDATE `address` AS `a` JOIN `address_profile` AS `ap` ON `a`.`id`=`ap`.`address_id` JOIN `profile` AS `p` ON `ap`.`profile_id`=`p`.`id` SET `a`.`user_id`=`p`.`user_id`;");

        DB::table('address')->whereNull('user_id')->delete();
        DB::table('address')->where('user_id', 0)->delete();

        Schema::table('address', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user');
        });

        Schema::dropIfExists('address_profile');
        Schema::dropIfExists('contact');
    }
}
