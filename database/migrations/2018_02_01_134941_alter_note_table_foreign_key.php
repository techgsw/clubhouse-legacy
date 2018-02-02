<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Note;

class AlterNoteTableForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('note', function (Blueprint $table) {
            $table->integer('contact_id')->unsigned()->nullable();
            $table->foreign('contact_id')->references('id')->on('contact');
        });

        foreach (Note::all() as $note) {
            DB::update('update note set contact_id = ' . $note->user->contact->id . ' where id = ' . $note->id);
            //$note->contact_id = $note->user->contact_id;
        }

        Schema::table('note', function (Blueprint $table) {
            $table->dropForeign('note_user_id_foreign');
            $table->dropColumn('user_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('note', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('user');
        });

        foreach (Note::all() as $note) {
            DB::update('update note set user_id = ' . $note->contact->user->id . ' where id = '. $note->id);
            //$note->contact_id = $note->user->contact_id;
        }

        Schema::table('note', function (Blueprint $table) {
            $table->dropForeign('note_contact_id_foreign');
            $table->dropColumn('contact_id');
        });
        
    }
}
