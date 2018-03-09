<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteNoteAcl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('resource')->insert(
            array(
                'code' => 'note_delete',
                'description' => "Can delete any note"
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'note_delete',
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
        DB::table('resource_role')->where('resource_code', 'note_delete')->delete();
        DB::table('resource')->where('code', 'note_delete')->delete();
    }
}
