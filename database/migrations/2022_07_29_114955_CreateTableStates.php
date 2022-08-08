<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state', 50)->unique();
            $table->string('abbrev', 5);
            $table->string('country', 5);
        });

        $file = public_path('files') . '/states.csv';

        $row = 1;
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row === 1) {
                    $row++;
                    continue;
                }
                DB::table('states')->insert(
                    [
                        'state' => $data[0],
                        'abbrev' => $data[1],
                        'country' => $data[2],
                    ]
                );
                $row++;
            }
            fclose($handle);
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
