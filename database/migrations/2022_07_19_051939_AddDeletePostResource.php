<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddDeletePostResource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('resource')->insert(
            array(
                'code' => 'post_delete',
                'description' => "Can delete a blog post."
            )
        );
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        DB::delete('delete from resource where code = "post_delete"');
        Schema::enableForeignKeyConstraints();
    }
}
