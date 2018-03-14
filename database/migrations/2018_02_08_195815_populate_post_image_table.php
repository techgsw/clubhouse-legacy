<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Post;
use App\PostImage;

class PopulatePostImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Post::all() as $post) {
            $legacy = true;
            preg_match('/[^\/]*$/', $post->image_url, $matches);
            $image_name = $matches[0];
            if (preg_match('/^medium-/', $image_name)) {
                $legacy = false;
                $image_name = preg_replace('/^medium-/', '', $image_name);
            }
            try {
                if ($legacy) {
                    mkdir(storage_path('app/public/post/'.$post->id));
                    $cp_image_name = preg_replace('/\./', '*.', $post->image_url);
                    exec("cp ".public_path($cp_image_name).' '.storage_path('app/public/post/'.$post->id.'/'));
                }
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            $post_image = PostImage::create([
                'post_id' => $post->id,
                'filename' => $image_name,
                'image_order' => 1,
                'legacy' => $legacy,
                'cdn_upload' => false
            ]);
        }

        Schema::table('post', function (Blueprint $table) {
            $table->dropColumn([
                'image_url'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // TODO bring things back to post table

        DB::table('post_image')->where('id', '>', 0)->delete();
    }
}
