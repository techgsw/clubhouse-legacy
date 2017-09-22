<?php

use App\Address;
use App\Profile;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            // Foreign keys
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user');
            // Fields
            $table->string('name')->nullable()->default(NULL);
            $table->string('line1')->nullable()->default(NULL);
            $table->string('line2')->nullable()->default(NULL);
            $table->string('city')->nullable()->default(NULL);
            $table->string('state')->nullable()->default(NULL);
            $table->string('postal_code')->nullable()->default(NULL);
            $table->string('country')->nullable()->default(NULL);
            $table->timestamps();
        });

        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            // Foreign keys
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user');

            // Phone number
            $table->string('phone')->nullable()->default(NULL);
            // Upload resume
            $table->string('resume_url')->nullable()->default(NULL);
            // Headshot
            $table->string('headshot_url')->nullable()->default(NULL);

            // Personal information

            // Date of Birth
            $table->date('date_of_birth')->nullable()->default(NULL);
            // Ethnicity
            // • asian => Asian or Pacific Islander
            // • black => Black or African American
            // • hispanic => Hispanic
            // • native => Native American
            // • white => White or Caucasian
            $table->string('ethnicity')->nullable()->default(NULL);
            // Gender
            // • female => Female
            // • male => Male
            // • non_binary => Non-binary
            $table->string('gender')->nullable()->default(NULL);

            // Job-seeking preferences

            // What is your job-seeking status? (Select one)
            // • unemployed => Unemployed, actively seeking a new job
            // • employed_active => Employed, actively seeking a new job
            // • employed_passive => Employed, passively exploring new opportunities
            // • employed_future => Employed, only open to future opportunities
            // • employed_not => Employed, currently have my dream job
            $table->string('job_seeking_status')->nullable()->default(NULL);
            // Which type of job most closely fits your goals? (Select one)
            // • junior => Junior-level
            // • senior => Senior-level
            // • management => Management
            // • executive => Executive
            $table->string('job_seeking_type')->nullable()->default(NULL);
            // Which department(s) most closely match your goals?
            // • department_goals_ticket_sales => Ticket Sales
            // • department_goals_sponsorship_sales => Sponsorship Sales
            // • department_goals_service => Service
            // • department_goals_premium_sales => Premium Sales
            // • department_goals_marketing => Marketing
            // • department_goals_sponsorship_activation => Sponsorship Activation
            // • department_goals_hr => HR
            // • department_goals_analytics => Analytics
            // • department_goals_cr => CR
            // • department_goals_pr => PR
            // • department_goals_database => Database
            // • department_goals_finance => Finance
            // • department_goals_arena_ops => Arena Ops
            // • department_goals_player_ops => Player Ops
            // • department_goals_event_ops => Event Ops
            // • department_goals_social_media => Digital/Social Media
            // • department_goals_entertainment => Game Entertainment
            // • department_goals_legal => Legal
            // • department_goals_other => Other: ____
            $table->boolean('department_goals_ticket_sales')->default(false);
            $table->boolean('department_goals_sponsorship_sales')->default(false);
            $table->boolean('department_goals_service')->default(false);
            $table->boolean('department_goals_premium_sales')->default(false);
            $table->boolean('department_goals_marketing')->default(false);
            $table->boolean('department_goals_sponsorship_activation')->default(false);
            $table->boolean('department_goals_hr')->default(false);
            $table->boolean('department_goals_analytics')->default(false);
            $table->boolean('department_goals_cr')->default(false);
            $table->boolean('department_goals_pr')->default(false);
            $table->boolean('department_goals_database')->default(false);
            $table->boolean('department_goals_finance')->default(false);
            $table->boolean('department_goals_arena_ops')->default(false);
            $table->boolean('department_goals_player_ops')->default(false);
            $table->boolean('department_goals_event_ops')->default(false);
            $table->boolean('department_goals_social_media')->default(false);
            $table->boolean('department_goals_entertainment')->default(false);
            $table->boolean('department_goals_legal')->default(false);
            $table->string('department_goals_other')->nullable()->default(NULL);
            // Which region are you most interested in working in?
            // • mw => Midwest
            // • ne => Northeast
            // • nw => Northwest
            // • se => Southeast
            // • sw => Southwest
            $table->string('job_seeking_region')->nullable()->default(NULL);
            // When making a decision on your next job in sports which of the following are most important? Choose three.
            // • Money
            $table->boolean('job_factors_money')->default(false);
            //   • What is your desired annual income? (Select one)
            //     • below_30 =>  below 30,000
            //     • 30_to_50 =>  30,000-50,000
            //     • 50_to_80 =>  50,000-80,000
            //     • 80_to_120 => 80,000-120,000
            //     • 120_above => 120,000+
            $table->string('job_seeking_income')->nullable()->default(NULL);
            // • Title
            $table->boolean('job_factors_title')->default(false);
            //   • What is your desired title? (Text)
            $table->string('job_seeking_title')->nullable()->default(NULL);
            // • Location
            $table->boolean('job_factors_location')->default(false);
            // • Organization
            $table->boolean('job_factors_organization')->default(false);
            //   • Which organization(s)?
            $table->text('job_seeking_organizations')->nullable()->default(NULL);
            // • Benefits
            $table->boolean('job_factors_benefits')->nullable()->default(NULL);
            // • Other (Text)
            $table->string('job_factors_other')->nullable()->default(NULL);

            // Employment History

            // Do you currently work in sports?
            $table->boolean('works_in_sports')->nullable()->default(NULL);
            // What organization do you currently work for?
            $table->string('current_organization')->nullable()->default(NULL);
            // What is your current title?
            $table->string('current_title')->nullable()->default(NULL);
            // Which region do you currently work in?
            // • mw => Midwest
            // • ne => Northeast
            // • nw => Northwest
            // • se => Southeast
            // • sw => Southwest
            $table->string('current_region')->nullable()->default(NULL);
            // How many years have you been with your current organization?
            // • less_1 => less than a year
            // • 1_to_3 => 1-3 years
            // • 3_to_6 => 3-6 years
            // • 6_more => 6+ years
            $table->string('current_organization_years')->nullable()->default(NULL);
            // How many years have you had your current title?
            // • less_1 => less than a year
            // • 1_to_3 => 1-3 years
            // • 3_to_6 => 3-6 years
            // • 6_more => 6+ years
            $table->string('current_title_years')->nullable()->default(NULL);
            // Which departments do you have experience in?
            // • department_experience_ticket_sales => Ticket Sales
            // • department_experience_sponsorship_sales => Sponsorship Sales
            // • department_experience_service => Service
            // • department_experience_premium_sales => Premium Sales
            // • department_experience_marketing => Marketing
            // • department_experience_sponsorship_activation => Sponsorship Activation
            // • department_experience_hr => HR
            // • department_experience_analytics => Analytics
            // • department_experience_cr => CR
            // • department_experience_pr => PR
            // • department_experience_database => Database
            // • department_experience_finance => Finance
            // • department_experience_arena_ops => Arena Ops
            // • department_experience_player_ops => Player Ops
            // • department_experience_event_ops => Event Ops
            // • department_experience_social_media => Digital/Social Media
            // • department_experience_entertainment => Game Entertainment
            // • department_experience_legal => Legal
            // • department_experience_other => Other: ___
            $table->boolean('department_experience_ticket_sales')->default(false);
            $table->boolean('department_experience_sponsorship_sales')->default(false);
            $table->boolean('department_experience_service')->default(false);
            $table->boolean('department_experience_premium_sales')->default(false);
            $table->boolean('department_experience_marketing')->default(false);
            $table->boolean('department_experience_sponsorship_activation')->default(false);
            $table->boolean('department_experience_hr')->default(false);
            $table->boolean('department_experience_analytics')->default(false);
            $table->boolean('department_experience_cr')->default(false);
            $table->boolean('department_experience_pr')->default(false);
            $table->boolean('department_experience_database')->default(false);
            $table->boolean('department_experience_finance')->default(false);
            $table->boolean('department_experience_arena_ops')->default(false);
            $table->boolean('department_experience_player_ops')->default(false);
            $table->boolean('department_experience_event_ops')->default(false);
            $table->boolean('department_experience_social_media')->default(false);
            $table->boolean('department_experience_entertainment')->default(false);
            $table->boolean('department_experience_legal')->default(false);
            $table->string('department_experience_other')->nullable()->default(NULL);

            // Educational History

            // What’s your highest education level completed?
            // • high-school => High school
            // • associate => Associate degree
            // • bachelor => Bachelor's degree
            // • master => Master's degree
            // • doctor => Doctorate (PhD, MD, JD, etc.)
            $table->string('education_level')->nullable()->default(NULL);
            // What college did/do you attend?
            $table->string('college_name')->nullable()->default(NULL);
            // What year did/will you graduate?
            $table->integer('college_graduation_year')->nullable()->default(NULL);
            // What is/was your undergraduate GPA?
            $table->double('college_gpa', 4, 2)->nullable()->default(NULL);
            // What collegiate organizations did/do you belong to? List any leadership positions you held.
            $table->text('college_organizations')->nullable()->default(NULL);
            // What sports business clubs or in your athletic department(s) were you involved in? List any leadership positions you held.
            $table->text('college_sports_clubs')->nullable()->default(NULL);
            // Do you plan to attend more school in the future?
            $table->boolean('has_school_plans')->nullable()->default(NULL);

            // Email preferences

            // I’m interested in receiving information on the following sports business topics (select all that apply)
            // • email_preference_entry_job => Getting an entry level job in sports
            // • email_preference_new_job => New job openings in sports
            // • email_preference_ticket_sales => Ticket sales tips and tricks
            // • email_preference_leadership => Sales Leadership/management/strategy
            // • email_preference_best_practices => Industry best practices and sports business articles
            // • email_preference_career_advice => Advice on how to grow your career in sports business
            $table->boolean('email_preference_entry_job')->default(false);
            $table->boolean('email_preference_new_job')->default(false);
            $table->boolean('email_preference_ticket_sales')->default(false);
            $table->boolean('email_preference_leadership')->default(false);
            $table->boolean('email_preference_best_practices')->default(false);
            $table->boolean('email_preference_career_advice')->default(false);
        });

        foreach (User::all() as $user) {
            $address = Address::create([
                'user_id' => $user->id,
                'name' => $user->getName()
            ]);
            $profile = Profile::create([
                'user_id' => $user->id,
                'phone' => $user->phone,
                'current_organization' => $user->organization,
                'current_title' => $user->title,
                'works_in_sports' => $user->is_sales_professinal,
            ]);
        }

        Schema::table('user', function (Blueprint $table) {
            if (Schema::hasColumn('user', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('user', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('user', 'organization')) {
                $table->dropColumn('organization');
            }
            if (Schema::hasColumn('user', 'is_sales_professional')) {
                $table->dropColumn('is_sales_professional');
            }
            if (Schema::hasColumn('user', 'is_interested_in_jobs')) {
                $table->dropColumn('is_interested_in_jobs');
            }
            if (Schema::hasColumn('user', 'receives_newsletter')) {
                $table->dropColumn('receives_newsletter');
            }
        });

        DB::table('resource')->insert(
            array(
                'code' => 'profile_show',
                'description' => "Can view any user profile"
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'profile_edit',
                'description' => "Can edit any user profile"
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_edit',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_edit',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_show',
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
        DB::table('resource_role')->where('resource_code', 'profile_show')->delete();
        DB::table('resource_role')->where('resource_code', 'profile_edit')->delete();
        DB::table('resource')->where('code', 'profile_show')->delete();
        DB::table('resource')->where('code', 'profile_edit')->delete();

        Schema::table('user', function (Blueprint $table) {
            $table->string('organization')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->string('phone')->nullable()->default(NULL);
            $table->boolean('is_sales_professional')->default(false);
            $table->boolean('receives_newsletter')->default(false);
            $table->boolean('is_interested_in_jobs')->default(true);
        });

        foreach (Profile::all() as $profile) {
            $user = $profile->user;
            $user->phone = $profile->phone;
            $user->organization = $profile->organization;
            $user->title = $profile->title;
            $user->is_sales_professional = is_null($profile->works_in_sports) || $profile->employed_in_sports_sales == ""
                ? false
                : $profile->employed_in_sports_sales;
            $user->is_interested_in_jobs = false;
            $user->save();
        }

        Schema::dropIfExists('address');
        Schema::dropIfExists('profile');
    }
}
