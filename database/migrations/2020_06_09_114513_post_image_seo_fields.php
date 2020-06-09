<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostImageSeoFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_image', function(Blueprint $table) {
            $table->string('caption')->nullable();
            $table->string('alt', 100)->nullable();
            $table->boolean('is_primary')->default(false);
        });

        // before this migration we've only had one image per blog post, all existing images should be primary
        DB::table('post_image')->update([
            'is_primary' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_image', function(Blueprint $table) {
            $table->dropColumn('is_primary');
            $table->dropColumn('caption');
            $table->dropColumn('alt');
        });
    }
}
