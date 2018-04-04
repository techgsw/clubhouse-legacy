<?php

use App\Job;
use App\Profile;
use App\PostImage;
use App\Image;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Storage::delete('log/migration.log');
        //
        // Schema::create('image', function (Blueprint $table) {
        //     $table->engine = 'InnoDB';
        //     $table->increments('id');
        //     $table->text('path');
        //     $table->boolean('cdn')->default(false);
        //     $table->integer('order')->unsigned()->nullable();
        //     // TODO Why do we care? Path should cover us, no?
        //     // $table->boolean('legacy')->default(false);
        //     $table->timestamps();
        // });
        //
        // // Profile headshots
        // Schema::table('profile', function (Blueprint $table) {
        //     $table->integer('headshot_image_id')->unsigned()->nullable()->after('headshot_url');
        //     $table->foreign('headshot_image_id')->references('id')->on('image');
        // });
        //
        // $success = 0;
        // $error = 0;
        // Storage::append('log/migration.log', "PROFILE-----------------");
        // Profile::whereNull('headshot_image_id')->each(function ($profile) use (&$success, &$error) {
        //     if (!$profile->headshot_url) {
        //         return;
        //     }
        //
        //     try {
        //         $image = new Image($profile->headshot_url);
        //     } catch (\Exception $e) {
        //         Storage::append('log/migration.log', "ERROR: {$e->getMessage()}");
        //         $error++;
        //         return;
        //     }
        //     if (!preg_match("/^headshot\/{$profile->user_id}\//", $profile->headshot_url)) {
        //         $dir = 'headshot/'.$profile->user_id;
        //         $ext = $image->getType();
        //         $filename = $profile->user->first_name.'-'.$profile->user->last_name.'-SportsBusinessSolutions.'.$ext;
        //
        //         if (!Storage::exists("public/{$dir}")) {
        //             Storage::makeDirectory("public/{$dir}");
        //         }
        //
        //         // Full: 2000 x 2000, cropped square from center
        //         $image_url = $image->cropFromCenter(2000)->saveAs($dir, 'full-'.$filename);
        //         // Large: 1000 x 1000
        //         $large = clone $image;
        //         $large_url = $large->resize(1000, 1000)->saveAs($dir, 'large-'.$filename);
        //         // Medium: 500 x 500
        //         $medium = clone $image;
        //         $medium_url = $medium->resize(500, 500)->saveAs($dir, 'medium-'.$filename);
        //         // Set Image's path to the newly-created medium version
        //         $image->path = $medium_url;
        //         // Small: 250 x 250
        //         $small = clone $image;
        //         $small_url = $small->resize(250, 250)->saveAs($dir, 'small-'.$filename);
        //
        //         // Delete original headshot image
        //         Storage::delete('public/'.$profile->headshot_url);
        //     }
        //     $image->save();
        //     Storage::append('log/migration.log', "{$image->id} {$image->path}");
        //
        //     $profile->headshot_url = $image->path;
        //     $profile->headshot_image_id = $image->id;
        //     $profile->save();
        //
        //     $success++;
        // });
        // Storage::append('log/migration.log', "{$success} successes\n{$error} errors\n------------------------");
        //
        // // Job images
        // Schema::table('job', function (Blueprint $table) {
        //     $table->integer('image_id')->unsigned()->nullable()->after('image_url');
        //     $table->foreign('image_id')->references('id')->on('image');
        // });

        $success = 0;
        $error = 0;
        Storage::append('log/migration.log', "JOB---------------------");
        Job::whereNull('image_id')->each(function ($job) {
            if (!$job->image_url) {
                return;
            }

            try {
                $image = new Image($job->image_url);
            } catch (\Exception $e) {
                Storage::append('log/migration.log', "ERROR: {$e->getMessage()}");
                $error++;
                return;
            }
            if (!preg_match("/^job\/{$job->id}\//", $job->image_url)) {
                $dir = 'job/'.$job->id;
                $ext = $image->getType();
                $filename = preg_replace('/\s/', '-', $job->organization).'-SportsBusinessSolutions.'.$ext;

                if (!Storage::exists("public/{$dir}")) {
                    Storage::makeDirectory("public/{$dir}");
                }

                // Full: original image
                $image_url = $image->saveAs($dir, 'full-'.$filename);
                // Large: 1000 x 1000
                $large = clone $image;
                $large_url = $large->resize(1000, 1000)->saveAs($dir, 'large-'.$filename);
                // Medium: 500 x 500
                $medium = clone $image;
                $medium_url = $medium->resize(500, 500)->saveAs($dir, 'medium-'.$filename);
                // Set Image's path to the newly-created medium version
                $image->path = $medium_url;
                // Small: 250 x 250
                $small = clone $image;
                $small_url = $small->resize(250, 250)->saveAs($dir, 'small-'.$filename);
                // Share: 1000 x 520, padded from 500 x 500, with white background
                $share = clone $medium;
                $share_url = $share->padTo(1000, 520, $white=[255, 255, 255])->saveAs($dir ,'share-'.$filename);

                // Delete original image
                Storage::delete('public/'.$job->image_url);
            }
            $image->save();
            Storage::append('log/migration.log', "{$image->id} {$image->path}");

            $job->image_id = $image->id;
            $job->save();
        });
        Storage::append('log/migration.log', "{$success} successes\n{$error} errors\n------------------------");

        // // Post images
        // Schema::table('post_image', function (Blueprint $table) {
        //     $table->integer('image_id')->unsigned()->nullable()->after('post_id');
        //     $table->foreign('image_id')->references('id')->on('image');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->dropForeign('headshot_image_id');
            $table->dropColumn('headshot_image_id');
        });
        Schema::table('job', function (Blueprint $table) {
            $table->dropForeign('image_id');
            $table->dropColumn('image_id');
        });
        // Schema::table('post_image', function (Blueprint $table) {
        //     $table->dropForeign('image_id');
        //     $table->dropColumn('image_id');
        // });
        Schema::dropIfExists('image');
    }
}
