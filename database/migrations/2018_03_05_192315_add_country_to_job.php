<?php

use App\Job;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryToJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job', function (Blueprint $table) {
            $table->string('country');
        });

        foreach (Job::all() as $job) {
            switch ($job->state) {
                case "AB":
                case "BC":
                case "MB":
                case "NB":
                case "NL":
                case "NS":
                case "ON":
                case "PE":
                case "QC":
                case "SK":
                case "NT":
                case "NU":
                case "YT":
                    $job->country = "CA";
                    break;
                default:
                    $job->country = "US";
                    break;
            }

            if ($job->id === 56) {
                $job->country = "UK";
                $job->state = "England";
                $job->city = "London";
            }

            $job->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job', function (Blueprint $table) {
            $table->dropColumn('country');
        });
    }
}
