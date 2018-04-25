<?php

use App\Email;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('code');
            $table->text('name');
            $table->timestamps();
        });

        Schema::create('email_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('email_id')->unsigned()->nullable();
            $table->foreign('email_id')->references('id')->on('email');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('user');
            $table->timestamps();
        });

        $registration_summary_email = new Email;
        $registration_summary_email->code = "registration_summary";
        $registration_summary_email->name = "Registrations (Summary)";
        $registration_summary_email->save();

        $registration_summary_emails = [
            'bob@sportsbusiness.solutions',
            'joshbelkoff@gmail.com',
            'adam@sportsbusiness.solutions'
        ];

        User::whereIn('email', $registration_summary_emails)->each(
            function ($user) use ($registration_summary_email) {
                $user->emails()->attach($registration_summary_email);
            }
        );

        $registration_individual_email = new Email;
        $registration_individual_email->code = "registration_individual";
        $registration_individual_email->name = "Registrations (Individual)";
        $registration_individual_email->save();

        $registration_individual_emails = [
            'bob@sportsbusiness.solutions',
            'joshbelkoff@gmail.com',
            'adam@sportsbusiness.solutions'
        ];

        User::whereIn('email', $registration_individual_emails)->each(
            function ($user) use ($registration_individual_email) {
                $user->emails()->attach($registration_individual_email);
            }
        );

        $inquiry_email = new Email;
        $inquiry_email->code = "inquiry_summary";
        $inquiry_email->name = "Job Applications (Summary)";
        $inquiry_email->save();

        $inquiry_emails = [
            'bob@sportsbusiness.solutions',
            'joshbelkoff@gmail.com',
            'adam@sportsbusiness.solutions',
            'Jason@sportsbusiness.solutions',
            'mike@sportsbusiness.solutions'
        ];

        User::whereIn('email', $inquiry_emails)->each(
            function ($user) use ($inquiry_email) {
                $user->emails()->attach($inquiry_email);
            }
        );

        DB::table('resource')->insert(
            array(
                'code' => 'email_edit',
                'description' => "Can edit list of which users receive which emails."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'email_edit',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'email_edit',
                'role_code' => 'developer'
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
        DB::table('resource_role')->where('resource_code', 'email_edit')->delete();
        DB::table('resource')->where('code', 'email_edit')->delete();
        Schema::dropIfExists('email_user');
        Schema::dropIfExists('email');
    }
}
