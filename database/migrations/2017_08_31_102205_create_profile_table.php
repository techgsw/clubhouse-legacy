<?php

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
            $table->string('name')->default(NULL);
            $table->string('line1')->default(NULL);
            $table->string('line2')->default(NULL);
            $table->string('city')->default(NULL);
            $table->string('state')->default(NULL);
            $table->string('postal_code')->default(NULL);
            $table->string('country')->default(NULL);
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
            $table->string('phone');
            // Date of Birth
            $table->date('date_of_birth');
            // Ethnicity
            // - Asian or Pacific Islander
            // - Black or African American
            // - Hispanic
            // - Native American
            // - White or Caucasian
            $table->string('ethnicity');
            // Gender
            // - Female
            // - Male
            // - Non-binary
            $table->string('gender');
            // Headshot
            $table->string('headshot')->default(NULL);

            // Job preferences

            // Employment status
            // - full-time => Employed full-time
            // - part-time => Employed part-time
            // - none => Unemployed
            $table->string('employment_status')->default(NULL);
            // How would you describe your job-seeking status?
            // - active => Actively looking
            // - passive => Happy where I am but open to good opportunities
            // - not => Happy where I am and not open to anything new
            $table->string('job_seeking_status')->default(NULL);
            // Do you want to be considered for future jobs in the sports industry?
            $table->boolean('receives_job_notifications')->default(NULL);
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
            $table->json('department_interests')->default(NULL);
            // When making a decision on your next job in sports which of the following are most important? Choose three.
            // - ?
            $table->json('job_decision_factors')->default(NULL);
            // Are you currently employed in sports sales?
            $table->boolean('employed_in_sports_sales')->default(NULL);
            // Do you want to continue your career in sports sales?
            $table->boolean('continuing_sports_sales')->default(NULL);
            // If yes, which sports sales job is the next step for you?
            // - inside-sales => Inside Sales – Entry level sales
            // - executive-sales => Account Executive, Group or Season Sales – Mid level sales
            // - executive-service => Account Executive, Service and Retention – Mid level service
            // - premium-sales => Premium Sales – Advanced sales
            // - sponsorship-sales => Sponsorship Sales – Sr. and Exec. level sales
            // - manager => Manager – Inside Sales – Managing entry level sales team
            $table->string('next_sales_job')->default(NULL);
            // Are you a sports sales manager?
            $table->boolean('is_sports_sales_manager')->default(NULL);
            // Do you want to continue your career in sports sales leadership?
            $table->boolean('continuing_management')->default(NULL);
            // If yes, what management job is the next step for you?
            // - manager-entry => Manager – Inside Sales – Managing entry level team
            // - manager-mid => Manager - Season, Premium, Group, Service, Sponsorship, Activation – Managing mid level team
            // - director => Director - Seasons, Premium, Group, Service, Sponsorship, Activation – Running strategy for your team
            // - sr-director => Sr. Director – Running strategy for multiple departments and managing managers                                                                                                                 v.            Vice President – Ticket Sales, Service and Retention, Sponsorship – Running the whole operation
            $table->string('next_management_job')->default(NULL);
            // Are you an executive in sports business?
            $table->boolean('is_executive')->default(NULL);
            // Do you want to continue your career as a sports executive?
            $table->boolean('continuing_executive')->default(NULL);
            // If yes, which is the next step for you?
            // - vp => VP
            // - svp => SVP
            // - evp => EVP
            // - cro => CRO
            // - cmo => CMO
            // - c => C Level (TODO what's this? -> "+ - Running multiple business units at the executive level")
            $table->string('next_executive')->default(NULL);

            // Employment history

            // Are you currently working in sports?
            $table->boolean('works_in_sports')->default(NULL);
            // If yes, how many years have you worked in sports?
            $table->integer('years_in_sports')->default(NULL);
            // If yes, which organization?
            $table->string('current_organization')->default(NULL);
            // What geographic region do you work in?
            // - mw => Midwest
            // - ne => Northeast
            // - nw => Northwest
            // - se => Southeast
            // - sw => Southwest
            $table->string('current_region')->default(NULL);
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
            $table->string('current_department')->default(NULL);
            // What is your title?
            $table->string('current_title')->default(NULL);
            // How many years have you been with your current organization?
            $table->integer('years_current_organization')->default(NULL);
            // How many years have you been in your current role?
            $table->integer('years_current_role')->default(NULL);
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
            $table->json('department_experience')->default(NULL);
            // If not, where do you work now?
            $table->string('if_not_organization')->default(NULL);
            // What department do you work in?
            $table->string('if_not_department')->default(NULL);
            // What is your title?
            $table->string('if_not_title')->default(NULL);
            // How long have you been with your current organization?
            $table->string('if_not_years_current_organization')->default(NULL);
            // How long have you been in your current role?
            $table->string('if_not_years_current_role')->default(NULL);
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
            $table->json('if_not_department_experience')->default(NULL);
            // Upload resume
            $table->string('resume')->default(NULL);

            // Educational history: (Copy from current profile)
            // What’s your highest education level completed?
            // - high-school => High school
            // - associate => Associate degree
            // - bachelor => Bachelor's degree
            // - master => Master's degree
            // - doctor => Doctorate (PhD, MD, JD, etc.)
            $table->string('education_level')->default(NULL);
            // What college did/do you attend?
            $table->string('college')->default(NULL);
            // What year did/will you graduate?
            $table->integer('graduation_year')->default(NULL);
            // What is/was your undergraduate GPA?
            $table->double('gpa', 4, 2)->default(NULL);
            // What collegiate organizations did/do you belong to? List any leadership positions you held.
            $table->text('college_organizations')->default(NULL);
            // What sports business clubs or in your athletic department(s) were you involved in? List any leadership positions you held.
            $table->text('college_sports_clubs')->default(NULL);
            // Do you plan to attend more school in the future?
            $table->boolean('has_school_plans')->default(NULL);


            // Email preferences

            // I’m interested in receiving information on the following sports business topics (select all that apply)
            // - email_preference['entry-job'] => Getting an entry level job in sports
            // - email_preference['new-job'] => New job openings in sports
            // - email_preference['ticket-sales'] => Ticket sales tips and tricks
            // - email_preference['leadership'] => Sales Leadership/management/strategy
            // - email_preference['best-practices'] => Industry best practices and sports business articles
            // - email_preference['career-advice'] => Advice on how to grow your career in sports business
            $table->json('email_preference')->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
        Schema::dropIfExists('profile');
    }
}
