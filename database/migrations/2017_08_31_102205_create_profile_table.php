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
            // - asian => Asian or Pacific Islander
            // - black => Black or African American
            // - hispanic => Hispanic
            // - native => Native American
            // - white => White or Caucasian
            $table->string('ethnicity')->nullable()->default(NULL);
            // Gender
            // - female => Female
            // - male => Male
            // - non-bin => Non-binary
            $table->string('gender')->nullable()->default(NULL);
            // Headshot (FILE)
            $table->string('headshot')->nullable()->default(NULL);

            // Job preferences

            // Employment status
            // - full-time => Employed full-time
            // - part-time => Employed part-time
            // - none => Unemployed
            $table->string('employment_status')->nullable()->default(NULL);
            // How would you describe your job-seeking status?
            // - active => Actively looking
            // - passive => Happy where I am but open to good opportunities
            // - not => Happy where I am and not open to anything new
            $table->string('job_seeking_status')->nullable()->default(NULL);
            // Do you want to be considered for future jobs in the sports industry?
            $table->boolean('receives_job_notifications')->nullable()->default(NULL);
            // If yes, check all departments that interest you
            // - department_interests['ticket-sales'] => Ticket Sales
            // - department_interests['sponsorship-sales'] => Sponsorship Sales
            // - department_interests['service'] => Service
            // - department_interests['premium-sales'] => Premium Sales
            // - department_interests['marketing'] => Marketing
            // - department_interests['sponsorship-activation'] => Sponsorship Activation
            // - department_interests['hr'] => HR
            // - department_interests['analytics'] => Analytics
            // - department_interests['cr'] => CR
            // - department_interests['pr'] => PR
            // - department_interests['database'] => Database
            // - department_interests['finance'] => Finance
            // - department_interests['arena-ops'] => Arena Ops
            // - department_interests['player-ops'] => Player Ops
            // - department_interests['event-ops'] => Event Ops
            // - department_interests['social-media'] => Digital/Social Media
            // - department_interests['entertainment'] => Game Entertainment
            // - department_interests['legal'] => Legal
            // - TODO Other: ____
            $table->json('department_interests');
            // When making a decision on your next job in sports which of the following are most important? Choose three.
            // - ?
            $table->json('job_decision_factors');
            // Are you currently employed in sports sales?
            $table->boolean('employed_in_sports_sales')->nullable()->default(NULL);
            // Do you want to continue your career in sports sales?
            $table->boolean('continuing_sports_sales')->nullable()->default(NULL);
            // If yes, which sports sales job is the next step for you?
            // - inside-sales => Inside Sales – Entry level sales
            // - executive-sales => Account Executive, Group or Season Sales – Mid level sales
            // - executive-service => Account Executive, Service and Retention – Mid level service
            // - premium-sales => Premium Sales – Advanced sales
            // - sponsorship-sales => Sponsorship Sales – Sr. and Exec. level sales
            // - manager => Manager – Inside Sales – Managing entry level sales team
            $table->string('next_sales_job')->nullable()->default(NULL);
            // Are you a sports sales manager?
            $table->boolean('is_sports_sales_manager')->nullable()->default(NULL);
            // Do you want to continue your career in sports sales leadership?
            $table->boolean('continuing_management')->nullable()->default(NULL);
            // If yes, what management job is the next step for you?
            // - manager-entry => Manager – Inside Sales – Managing entry level team
            // - manager-mid => Manager - Season, Premium, Group, Service, Sponsorship, Activation – Managing mid level team
            // - director => Director - Seasons, Premium, Group, Service, Sponsorship, Activation – Running strategy for your team
            // - sr-director => Sr. Director – Running strategy for multiple departments and managing managers                                                                                                                 v.            Vice President – Ticket Sales, Service and Retention, Sponsorship – Running the whole operation
            $table->string('next_management_job')->nullable()->default(NULL);
            // Are you an executive in sports business?
            $table->boolean('is_executive')->nullable()->default(NULL);
            // Do you want to continue your career as a sports executive?
            $table->boolean('continuing_executive')->nullable()->default(NULL);
            // If yes, which is the next step for you?
            // - vp => VP
            // - svp => SVP
            // - evp => EVP
            // - cro => CRO
            // - cmo => CMO
            // - c => C Level (TODO what's this? -> "+ - Running multiple business units at the executive level")
            $table->string('next_executive')->nullable()->default(NULL);

            // Employment history

            // Are you currently working in sports?
            $table->boolean('works_in_sports')->nullable()->default(NULL);
            // If yes, how many years have you worked in sports?
            $table->integer('years_in_sports')->nullable()->default(NULL);
            // If yes, which organization?
            $table->string('current_organization')->nullable()->default(NULL);
            // What geographic region do you work in?
            // - mw => Midwest
            // - ne => Northeast
            // - nw => Northwest
            // - se => Southeast
            // - sw => Southwest
            $table->string('current_region')->nullable()->default(NULL);
            // What department do you work in?
            // - ticket-sales => Ticket Sales
            // - sponsorship-sales => Sponsorship Sales
            // - service => Service
            // - premium-sales => Premium Sales
            // - marketing => Marketing
            // - sponsorship-activation => Sponsorship Activation
            // - hr => HR
            // - analytics => Analytics
            // - cr => CR
            // - pr => PR
            // - database => Database
            // - finance => Finance
            // - arena-ops => Arena Ops
            // - player-ops => Player Ops
            // - event-ops => Event Ops
            // - social-media => Digital/Social Media
            // - entertainment => Game Entertainment
            // - legal => Legal
            // - TODO Other: ____
            $table->string('current_department')->nullable()->default(NULL);
            // What is your title?
            $table->string('current_title')->nullable()->default(NULL);
            // How many years have you been with your current organization?
            $table->integer('years_current_organization')->nullable()->default(NULL);
            // How many years have you been in your current role?
            $table->integer('years_current_role')->nullable()->default(NULL);
            // In sports, which departments do you have experience in? Check all that apply:
            // - department_experience['ticket-sales'] => Ticket Sales
            // - department_experience['sponsorship-sales'] => Sponsorship Sales
            // - department_experience['service'] => Service
            // - department_experience['premium-sales'] => Premium Sales
            // - department_experience['marketing'] => Marketing
            // - department_experience['sponsorship-activation'] => Sponsorship Activation
            // - department_experience['hr'] => HR
            // - department_experience['analytics'] => Analytics
            // - department_experience['cr'] => CR
            // - department_experience['pr'] => PR
            // - department_experience['database'] => Database
            // - department_experience['finance'] => Finance
            // - department_experience['arena-ops'] => Arena Ops
            // - department_experience['player-ops'] => Player Ops
            // - department_experience['event-ops'] => Event Ops
            // - department_experience['social-media'] => Digital/Social Media
            // - department_experience['entertainment'] => Game Entertainment
            // - department_experience['legal'] => Legal
            // - TODO Other: ____
            $table->json('department_experience');
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
            // Phone sales
            // door to door sales
            // territory management
            // B2B sales
            // customer service
            // sponsorship,
            // High level business development
            // marketing
            // analytics
            // BI
            // database
            // digital
            // web design
            // social media
            // HR
            // finance
            // accounting
            // organizational development
            // communications
            // PR
            // media relations
            // legal
            // IT
            // TODO Other:
            $table->json('if_not_department_experience');
            // Upload resume
            $table->string('resume')->nullable()->default(NULL);

            // Educational history: (Copy from current profile)
            // What’s your highest education level completed?
            // - high-school => High school
            // - associate => Associate degree
            // - bachelor => Bachelor's degree
            // - master => Master's degree
            // - doctor => Doctorate (PhD, MD, JD, etc.)
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
            // - email_preference['entry-job'] => Getting an entry level job in sports
            // - email_preference['new-job'] => New job openings in sports
            // - email_preference['ticket-sales'] => Ticket sales tips and tricks
            // - email_preference['leadership'] => Sales Leadership/management/strategy
            // - email_preference['best-practices'] => Industry best practices and sports business articles
            // - email_preference['career-advice'] => Advice on how to grow your career in sports business
            $table->json('email_preference');
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
                'receives_job_notifications' => $user->is_interested_in_jobs,
                'department_interests' => json_encode([]),
                'job_decision_factors' => json_encode([]),
                'department_experience' => json_encode([]),
                'if_not_department_experience' => json_encode([]),
                'email_preference' => json_encode([])
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
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
