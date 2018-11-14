<?php

use App\Email;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->string('description')->default("");
            $table->timestamps();
        });

        Schema::create('mentor_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mentor_id')->unsigned();
            $table->string('tag_name');
            $table->foreign('mentor_id')->references('id')->on('mentor');
            $table->foreign('tag_name')->references('name')->on('tag');
            $table->timestamps();
        });

        DB::table('resource')->insert(
            array(
                'code' => 'mentor_show',
                'description' => "Can view mentors."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_show',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'mentor_edit',
                'description' => "Can edit mentors."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_edit',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_edit',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'mentor_create',
                'description' => "Can create mentors."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_create',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_create',
                'role_code' => 'administrator'
            )
        );

        $mentorship_request_email = new Email;
        $mentorship_request_email->code = "mentorship_requests";
        $mentorship_request_email->name = "Mentorship requests";
        $mentorship_request_email->save();

        $mentorship_request_emails = [
            'bob@sportsbusiness.solutions'
        ];

        User::whereIn('email', $mentorship_request_emails)->each(
            function ($user) use ($mentorship_request_email) {
                $user->emails()->attach($mentorship_request_email);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $mentorship_request_email = Email::where('code', 'mentorship_requests')->first();
        DB::table('email_user')->where('email_id', $mentorship_request_email->id)->delete();
        DB::table('email')->where('id', $mentorship_request_email->id)->delete();

        Schema::dropIfExists('mentor_tag');
        Schema::dropIfExists('mentor');
        DB::table('resource_role')->where('resource_code', 'mentor_show')->delete();
        DB::table('resource')->where('code', 'mentor_show')->delete();
        DB::table('resource_role')->where('resource_code', 'mentor_create')->delete();
        DB::table('resource')->where('code', 'mentor_create')->delete();
        DB::table('resource_role')->where('resource_code', 'mentor_edit')->delete();
        DB::table('resource')->where('code', 'mentor_edit')->delete();
    }
}
