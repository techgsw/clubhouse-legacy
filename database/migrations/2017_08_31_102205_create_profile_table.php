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

            // Personal information

            // Phone number
            $table->string('phone')->nullable()->default(NULL);
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
            // Headshot
            $table->string('headshot_url')->nullable()->default(NULL);

            // Job preferences

            // Employment status
            // • full_time => Employed full-time
            // • part_time => Employed part-time
            // • none => Unemployed
            $table->string('employment_status')->nullable()->default(NULL);
            // How would you describe your job-seeking status?
            // • active => Actively looking
            // • passive => Happy where I am but open to good opportunities
            // • not => Happy where I am and not open to anything new
            $table->string('job_seeking_status')->nullable()->default(NULL);
            // Do you want to be considered for future jobs in the sports industry?
            $table->boolean('receives_job_notifications')->nullable()->default(NULL);
            // If yes, check all departments that interest you
            // • department_interests_ticket_sales => Ticket Sales
            // • department_interests_sponsorship_sales => Sponsorship Sales
            // • department_interests_service => Service
            // • department_interests_premium_sales => Premium Sales
            // • department_interests_marketing => Marketing
            // • department_interests_sponsorship_activation => Sponsorship Activation
            // • department_interests_hr => HR
            // • department_interests_analytics => Analytics
            // • department_interests_cr => CR
            // • department_interests_pr => PR
            // • department_interests_database => Database
            // • department_interests_finance => Finance
            // • department_interests_arena_ops => Arena Ops
            // • department_interests_player_ops => Player Ops
            // • department_interests_event_ops => Event Ops
            // • department_interests_social_media => Digital/Social Media
            // • department_interests_entertainment => Game Entertainment
            // • department_interests_legal => Legal
            // • department_interests_other => Other: ____
            $table->boolean('department_interests_ticket_sales')->default(false);
            $table->boolean('department_interests_sponsorship_sales')->default(false);
            $table->boolean('department_interests_service')->default(false);
            $table->boolean('department_interests_premium_sales')->default(false);
            $table->boolean('department_interests_marketing')->default(false);
            $table->boolean('department_interests_sponsorship_activation')->default(false);
            $table->boolean('department_interests_hr')->default(false);
            $table->boolean('department_interests_analytics')->default(false);
            $table->boolean('department_interests_cr')->default(false);
            $table->boolean('department_interests_pr')->default(false);
            $table->boolean('department_interests_database')->default(false);
            $table->boolean('department_interests_finance')->default(false);
            $table->boolean('department_interests_arena_ops')->default(false);
            $table->boolean('department_interests_player_ops')->default(false);
            $table->boolean('department_interests_event_ops')->default(false);
            $table->boolean('department_interests_social_media')->default(false);
            $table->boolean('department_interests_entertainment')->default(false);
            $table->boolean('department_interests_legal')->default(false);
            $table->string('department_interests_other')->nullable()->default(NULL);
            // When making a decision on your next job in sports which of the following are most important? Choose three.
            // • ?
            // TODO checkbox options
            $table->string('job_decision_factors_other')->nullable()->default(NULL);
            // Are you currently employed in sports sales?
            $table->boolean('employed_in_sports_sales')->nullable()->default(NULL);
            // Do you want to continue your career in sports sales?
            $table->boolean('continuing_sports_sales')->nullable()->default(NULL);
            // If yes, which sports sales job is the next step for you?
            // • inside_sales => Inside Sales – Entry level sales
            // • executive_sales => Account Executive, Group or Season Sales – Mid level sales
            // • executive_service => Account Executive, Service and Retention – Mid level service
            // • premium_sales => Premium Sales – Advanced sales
            // • sponsorship_sales => Sponsorship Sales – Sr. and Exec. level sales
            // • manager => Manager – Inside Sales – Managing entry level sales team
            $table->string('next_sales_job')->nullable()->default(NULL);
            // Are you a sports sales manager?
            $table->boolean('is_sports_sales_manager')->nullable()->default(NULL);
            // Do you want to continue your career in sports sales leadership?
            $table->boolean('continuing_management')->nullable()->default(NULL);
            // If yes, what management job is the next step for you?
            // • manager_entry => Manager – Inside Sales – Managing entry level team
            // • manager_mid => Manager - Season, Premium, Group, Service, Sponsorship, Activation – Managing mid level team
            // • director => Director - Seasons, Premium, Group, Service, Sponsorship, Activation – Running strategy for your team
            // • sr_director => Sr. Director – Running strategy for multiple departments and managing managers                                                                                                                 v.            Vice President – Ticket Sales, Service and Retention, Sponsorship – Running the whole operation
            $table->string('next_management_job')->nullable()->default(NULL);
            // Are you an executive in sports business?
            $table->boolean('is_executive')->nullable()->default(NULL);
            // Do you want to continue your career as a sports executive?
            $table->boolean('continuing_executive')->nullable()->default(NULL);
            // If yes, which is the next step for you?
            // • vp => VP
            // • svp => SVP
            // • evp => EVP
            // • cro => CRO
            // • cmo => CMO
            // • c => C Level (TODO what's this? -> "+ - Running multiple business units at the executive level")
            $table->string('next_executive_job')->nullable()->default(NULL);

            // Employment history

            // Are you currently working in sports?
            $table->boolean('works_in_sports')->nullable()->default(NULL);
            // If yes, how many years have you worked in sports?
            $table->integer('years_in_sports')->nullable()->default(NULL);
            // If yes, which organization?
            $table->string('current_organization')->nullable()->default(NULL);
            // What geographic region do you work in?
            // • mw => Midwest
            // • ne => Northeast
            // • nw => Northwest
            // • se => Southeast
            // • sw => Southwest
            $table->string('current_region')->nullable()->default(NULL);
            // What department do you work in?
            // • current_department_ticket_sales => Ticket Sales
            // • current_department_sponsorship_sales => Sponsorship Sales
            // • current_department_service => Service
            // • current_department_premium_sales => Premium Sales
            // • current_department_marketing => Marketing
            // • current_department_sponsorship_activation => Sponsorship Activation
            // • current_department_hr => HR
            // • current_department_analytics => Analytics
            // • current_department_cr => CR
            // • current_department_pr => PR
            // • current_department_database => Database
            // • current_department_finance => Finance
            // • current_department_arena_ops => Arena Ops
            // • current_department_player_ops => Player Ops
            // • current_department_event_ops => Event Ops
            // • current_department_social_media => Digital/Social Media
            // • current_department_entertainment => Game Entertainment
            // • current_department_legal => Legal
            // • current_department_other => Other: ____
            $table->boolean('current_department_ticket_sales')->default(false);
            $table->boolean('current_department_sponsorship_sales')->default(false);
            $table->boolean('current_department_service')->default(false);
            $table->boolean('current_department_premium_sales')->default(false);
            $table->boolean('current_department_marketing')->default(false);
            $table->boolean('current_department_sponsorship_activation')->default(false);
            $table->boolean('current_department_hr')->default(false);
            $table->boolean('current_department_analytics')->default(false);
            $table->boolean('current_department_cr')->default(false);
            $table->boolean('current_department_pr')->default(false);
            $table->boolean('current_department_database')->default(false);
            $table->boolean('current_department_finance')->default(false);
            $table->boolean('current_department_arena_ops')->default(false);
            $table->boolean('current_department_player_ops')->default(false);
            $table->boolean('current_department_event_ops')->default(false);
            $table->boolean('current_department_social_media')->default(false);
            $table->boolean('current_department_entertainment')->default(false);
            $table->boolean('current_department_legal')->default(false);
            $table->string('current_department_other')->nullable()->default(NULL);
            // What is your title?
            $table->string('current_title')->nullable()->default(NULL);
            // How many years have you been with your current organization?
            $table->integer('years_current_organization')->nullable()->default(NULL);
            // How many years have you been in your current role?
            $table->integer('years_current_role')->nullable()->default(NULL);
            // In sports, which departments do you have experience in? Check all that apply:
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
            // If not, where do you work now?
            $table->string('if_not_organization')->nullable()->default(NULL);
            // What department do you work in?
            $table->string('if_not_department')->nullable()->default(NULL);
            // What is your title?
            $table->string('if_not_title')->nullable()->default(NULL);
            // How long have you been with your current organization?
            $table->string('if_not_years_current_organization')->nullable()->default(NULL);
            // How long have you been in your current role?
            $table->string('if_not_years_current_role')->nullable()->default(NULL);
            // What departments do you have experience in? Check all that apply:
            // • if_not_department_experience_phone_sales => Phone sales
            // • if_not_department_experience_door_to_door_sales => Door-to-door sales
            // • if_not_department_experience_territory_management => Territory managements
            // • if_not_department_experience_b2b_sales => Business-to-business sales
            // • if_not_department_experience_customer service => Customer service
            // • if_not_department_experience_sponsorship => Sponsorship
            // • if_not_department_experience_high_level_business_development => High level business development
            // • if_not_department_experience_marketing => Marketing
            // • if_not_department_experience_analytics => Analytics
            // • if_not_department_experience_bi => B.I.
            // • if_not_department_experience_database => Database
            // • if_not_department_experience_digital => Digital
            // • if_not_department_experience_web_design => Web design
            // • if_not_department_experience_social_media => Social media
            // • if_not_department_experience_hr => HR
            // • if_not_department_experience_finance => Finance
            // • if_not_department_experience_accounting => Accounting
            // • if_not_department_experience_organizational_development => Organizational development
            // • if_not_department_experience_communications => Communications
            // • if_not_department_experience_pr => PR
            // • if_not_department_experience_media_relations => Media relations
            // • if_not_department_experience_legal => Legal
            // • if_not_department_experience_it => IT
            // • if_not_department_experience_other => Other: __
            $table->boolean('if_not_department_experience_phone_sales')->default(false);
            $table->boolean('if_not_department_experience_door_to_door_sales')->default(false);
            $table->boolean('if_not_department_experience_territory_management')->default(false);
            $table->boolean('if_not_department_experience_b2b_sales')->default(false);
            $table->boolean('if_not_department_experience_customer')->default(false);
            $table->boolean('if_not_department_experience_sponsorship')->default(false);
            $table->boolean('if_not_department_experience_high_level_business_development')->default(false);
            $table->boolean('if_not_department_experience_marketing')->default(false);
            $table->boolean('if_not_department_experience_analytics')->default(false);
            $table->boolean('if_not_department_experience_bi')->default(false);
            $table->boolean('if_not_department_experience_database')->default(false);
            $table->boolean('if_not_department_experience_digital')->default(false);
            $table->boolean('if_not_department_experience_web_design')->default(false);
            $table->boolean('if_not_department_experience_social_media')->default(false);
            $table->boolean('if_not_department_experience_hr')->default(false);
            $table->boolean('if_not_department_experience_finance')->default(false);
            $table->boolean('if_not_department_experience_accounting')->default(false);
            $table->boolean('if_not_department_experience_organizational_development')->default(false);
            $table->boolean('if_not_department_experience_communications')->default(false);
            $table->boolean('if_not_department_experience_pr')->default(false);
            $table->boolean('if_not_department_experience_media_relations')->default(false);
            $table->boolean('if_not_department_experience_legal')->default(false);
            $table->boolean('if_not_department_experience_it')->default(false);
            $table->string('if_not_department_experience_other')->nullable()->default(NULL);
            // Upload resume
            $table->string('resume_url')->nullable()->default(NULL);

            // Educational history: (Copy from current profile)
            // What’s your highest education level completed?
            // • high-school => High school
            // • associate => Associate degree
            // • bachelor => Bachelor's degree
            // • master => Master's degree
            // • doctor => Doctorate (PhD, MD, JD, etc.)
            $table->string('education_level')->nullable()->default(NULL);
            // What college did/do you attend?
            $table->string('college')->nullable()->default(NULL);
            // What year did/will you graduate?
            $table->integer('graduation_year')->nullable()->default(NULL);
            // What is/was your undergraduate GPA?
            $table->double('gpa', 4, 2)->nullable()->default(NULL);
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
                'employed_in_sports_sales' => $user->is_sales_professinal,
                'receives_job_notifications' => $user->is_interested_in_jobs
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
            $user->is_sales_professional = is_null($profile->employed_in_sports_sales) || $profile->employed_in_sports_sales == ""
                ? false
                : $profile->employed_in_sports_sales;
            $user->is_interested_in_jobs = is_null($profile->receives_job_notifications) || $profile->receives_job_notifications == ""
                ? false
                : $profile->receives_job_notifications;
            $user->save();
        }

        Schema::dropIfExists('address');
        Schema::dropIfExists('profile');
    }
}
