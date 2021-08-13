<?php

use App\Mentor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MentorActivatedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mentor', function (Blueprint $table) {
            $table->timestamp('activated_at')->nullable()->default(null);
        });
        Mentor::where('active', true)
            ->update([ 'activated_at' => \DB::raw('created_at') ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mentor', function(Blueprint $table) {
            $table->dropColumn('activated_at');
        });
    }
}
