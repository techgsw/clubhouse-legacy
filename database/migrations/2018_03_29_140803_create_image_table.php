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
        Storage::delete('log/migration.log');

        Schema::create('image', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('path');
            $table->boolean('cdn')->default(false);
            $table->integer('order')->unsigned()->default(1);
            $table->timestamps();
        });

        // Profile headshots
        Schema::table('profile', function (Blueprint $table) {
            $table->integer('headshot_image_id')->unsigned()->nullable()->after('headshot_url');
            $table->foreign('headshot_image_id')->references('id')->on('image');
        });

        $success = 0;
        $error = 0;
        Storage::append('log/migration.log', "PROFILE-----------------");
        Profile::whereNull('headshot_image_id')->each(function ($profile) use (&$success, &$error) {
            if (!$profile->headshot_url) {
                return;
            }

            if (!preg_match("/^headshot\/{$profile->user_id}\//", $profile->headshot_url)) {
                try {
                    $image = new Image($profile->headshot_url);
                } catch (\Exception $e) {
                    Storage::append('log/migration.log', "ERROR: {$e->getMessage()}");
                    $error++;
                    return;
                }

                $dir = 'headshot/'.$profile->user_id;
                $ext = $image->getType();
                $filename = $profile->user->first_name.'-'.$profile->user->last_name.'-Sports-Business-Solutions.'.$ext;

                if (!Storage::exists("public/{$dir}")) {
                    Storage::makeDirectory("public/{$dir}");
                }

                // Full: 2000 x 2000, cropped square from center
                $image_path = $image->cropFromCenter(2000)->saveAs($dir, $filename);
                $image->path = $image_path;
                // Large: 1000 x 1000
                $large = clone $image;
                $large_url = $large->resize(1000, 1000)->saveAs($dir, 'large-'.$filename);
                // Medium: 500 x 500
                $medium = clone $image;
                $medium_url = $medium->resize(500, 500)->saveAs($dir, 'medium-'.$filename);
                // Small: 250 x 250
                $small = clone $image;
                $small_url = $small->resize(250, 250)->saveAs($dir, 'small-'.$filename);

                // Delete original headshot image
                Storage::delete('public/'.$profile->headshot_url);
            } else {
                $path = $profile->headshot_url;
                if (preg_match("/^headshot\/{$profile->user_id}\/medium-/", $profile->headshot_url)) {
                    // Use main instead of medium
                    $dirs = explode("/", $profile->headshot_url);
                    $fn = array_pop($dirs);
                    $root = preg_replace("/^(medium-)/", "main-", $fn);
                    $dirs[] = $root;
                    $path = implode("/", $dirs);
                }

                try {
                    $image = new Image($path);
                } catch (\Exception $e) {
                    Storage::append('log/migration.log', "ERROR: {$e->getMessage()}");
                    $error++;
                    return;
                }

                $dir = 'headshot/'.$profile->user_id;
                $ext = $image->getType();
                $filename = $profile->user->first_name.'-'.$profile->user->last_name.'-Sports-Business-Solutions.'.$ext;

                if (!Storage::exists("public/{$dir}")) {
                    Storage::makeDirectory("public/{$dir}");
                }

                // Save main without prefix
                $image_path = $image->saveAs($dir, $filename);
                $image->path = $image_path;
            }

            $image->save();
            Storage::append('log/migration.log', "{$image->id} {$image->path}");

            $profile->headshot_url = $image->path;
            $profile->headshot_image_id = $image->id;
            $profile->save();

            $success++;
        });
        Storage::append('log/migration.log', "{$success} successes\n{$error} errors\n------------------------");

        // Job images
        Schema::table('job', function (Blueprint $table) {
            $table->integer('image_id')->unsigned()->nullable()->after('image_url');
            $table->foreign('image_id')->references('id')->on('image');
        });

        $success = 0;
        $error = 0;
        Storage::append('log/migration.log', "JOB---------------------");
        Job::whereNull('image_id')->each(function ($job) use (&$success, &$error) {
            if (!$job->image_url) {
                return;
            }

            if (!preg_match("/^job\/{$job->id}\//", $job->image_url)) {
                try {
                    $image = new Image($job->image_url);
                } catch (\Exception $e) {
                    Storage::append('log/migration.log', "ERROR: {$e->getMessage()}");
                    $error++;
                    return;
                }

                $dir = 'job/'.$job->id;
                $ext = $image->getType();
                $filename = preg_replace("/(\s)+/", '-', str_replace("/", "", $job->organization)).'-Sports-Business-Solutions.'.$ext;

                if (!Storage::exists("public/{$dir}")) {
                    Storage::makeDirectory("public/{$dir}");
                }

                // Full: original image
                $image_path = $image->saveAs($dir, $filename);
                $image->path = $image_path;
                // Large: 1000 x 1000
                $large = clone $image;
                $large_url = $large->resize(1000, 1000)->saveAs($dir, 'large-'.$filename);
                // Medium: 500 x 500
                $medium = clone $image;
                $medium_url = $medium->resize(500, 500)->saveAs($dir, 'medium-'.$filename);
                // Small: 250 x 250
                $small = clone $image;
                $small_url = $small->resize(250, 250)->saveAs($dir, 'small-'.$filename);
                // Share: 1000 x 520, padded from 500 x 500, with white background
                $share = clone $medium;
                $share_url = $share->padTo(1000, 520, $white=[255, 255, 255])->saveAs($dir ,'share-'.$filename);

                // Delete original image
                Storage::delete('public/'.$job->image_url);
            } else {
                $path = $job->image_url;
                if (preg_match("/^job\/{$job->id}\/medium-/", $job->image_url)) {
                    // Use main instead of medium
                    $dirs = explode("/", $job->image_url);
                    $fn = array_pop($dirs);
                    $root = preg_replace("/^(medium-)/", "original-", $fn);
                    $dirs[] = $root;
                    $path = implode("/", $dirs);
                }

                try {
                    $image = new Image($path);
                } catch (\Exception $e) {
                    Storage::append('log/migration.log', "ERROR: {$e->getMessage()}");
                    $error++;
                    return;
                }

                $dir = 'job/'.$job->id;
                $ext = $image->getType();
                $filename = preg_replace("/(\s)+/", '-', str_replace("/", "", $job->organization)).'-Sports-Business-Solutions.'.$ext;

                if (!Storage::exists("public/{$dir}")) {
                    Storage::makeDirectory("public/{$dir}");
                }

                // Save main without prefix
                $image_path = $image->saveAs($dir, $filename);
                $image->path = $image_path;
            }

            $image->save();
            Storage::append('log/migration.log', "{$image->id} {$image->path}");

            $job->image_url = $image->path;
            $job->image_id = $image->id;
            $job->save();

            $success++;
        });
        Storage::append('log/migration.log', "{$success} successes\n{$error} errors\n------------------------");

        // PostImages
        Schema::table('post_image', function (Blueprint $table) {
            $table->integer('image_id')->unsigned()->nullable()->after('post_id');
            $table->foreign('image_id')->references('id')->on('image');
        });

        $success = 0;
        $error = 0;
        Storage::append('log/migration.log', "POST-IMAGE--------------");
        PostImage::whereNull('image_id')->each(function ($post_image) use (&$success, &$error) {
            if ($post_image->legacy) {
                $path = "post/$post_image->post_id/$post_image->filename";
            } else {
                $path = "post/$post_image->post_id/main-$post_image->filename";
            }

            try {
                $image = new Image($path);
            } catch (\Exception $e) {
                Storage::append('log/migration.log', "ERROR: {$e->getMessage()}");
                $error++;
                return;
            }

            if (!$post_image->legacy) {
                // Save main without prefix
                $image_path = $image->saveAs("post/$post_image->post_id", $post_image->filename);
                $image->path = $image_path;
            }

            $image->order = $post_image->image_order;
            $image->save();
            Storage::append('log/migration.log', "{$image->id} {$image->path}");

            $post_image->image_id = $image->id;
            $post_image->save();

            $success++;
        });
        Storage::append('log/migration.log', "{$success} successes\n{$error} errors\n------------------------");
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
        Schema::table('post_image', function (Blueprint $table) {
            $table->dropForeign('image_id');
            $table->dropColumn('image_id');
        });
        Schema::dropIfExists('image');
    }
}
