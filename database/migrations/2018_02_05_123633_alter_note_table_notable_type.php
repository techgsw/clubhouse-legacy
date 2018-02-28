<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNoteTableNotableType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update('update note n join profile p on n.notable_id = p.id join contact c on p.user_id = c.user_id set notable_id = c.id , notable_type = "App\\\Contact" where notable_type = "App\\\Profile";');    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update('update note n join contact c on n.notable_id = c.id join profile p on c.user_id = p.user_id set notable_id = p.id , notable_type = "App\\\Profile" where notable_type = "App\\\Contact";');
    }
}
