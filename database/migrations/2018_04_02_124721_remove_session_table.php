<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Post;
use App\PostImage;
use App\Session;
use App\Providers\ImageServiceProvider;

class RemoveSessionTable extends Migration
{

    public function createPost($session)
    {
        $title_url = preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', mb_strtolower($session->title)));
        return Post::create([
            'user_id' => $session->user_id,
            'title' => $session->title,
            'body' => $session->title,
            'title_url' => $title_url,
            'post_type_code' => 'session'
        ]);
    }

    public function saveImages($post, $image_url, $display_order)
    {
        $storage_path = storage_path().'/app/public/post/'.$post->id;
        if (!file_exists($storage_path)) {
            mkdir($storage_path, '0755');
        }
        $filename = $display_order.time().'-'.$post->title_url.'-Sports-Business-Solutions.jpg';

        $image_relative_path = $image_url;

        $main_image = new ImageServiceProvider(base_path().'/public'.$image_relative_path);
        $main_image->cropFromCenter(2000);
        $main_image->save($storage_path.'/main-'.$filename);


        $large_image = new ImageServiceProvider(base_path().'/public'.$image_relative_path);
        $large_image->resize(1000, 1000);
        $large_image->save($storage_path.'/large-'.$filename);

        $medium_image = new ImageServiceProvider(base_path().'/public'.$image_relative_path);
        $medium_image->resize(500, 500);
        $medium_image->save($storage_path.'/medium-'.$filename);

        $small_image = new ImageServiceProvider(base_path().'/public'.$image_relative_path);
        $small_image->resize(250, 250);
        $small_image->save($storage_path.'/small-'.$filename);

        $width = $medium_image->getCurrentWidth();
        $height = $medium_image->getCurrentHeight();
        $dest_x = (1000-$width)/2;
        $dest_y = (520-$height)/2;

        $background_fill_image = imagecreatetruecolor(1000, 520);
        $white_color = imagecolorallocate($background_fill_image, 255, 255, 255);
        imagefill($background_fill_image, 0, 0, $white_color);
        imagecopy($background_fill_image, $medium_image->getNewImage(), $dest_x, $dest_y, 0, 0, $width, $height);
        imagejpeg($background_fill_image, $storage_path.'share-'.$filename, 100);

        $post_image = new PostImage();
        $post_image->post_id = $post->id;
        $post_image->filename = $filename;
        $post_image->image_order = $display_order;

        $post_image->save();
    }

    public function up()
    {
        $prev_post = null;
        $display_order = 1;
        foreach (Session::all() as $index => $session) {
            try {
                // 1-4
                if ($index ==  0) {
                    $session->title = 'Denver Nuggets';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 5-6 
                if ($index ==  4) {
                    $session->title = 'AHL Marketing';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 7-9 
                if ($index ==  6) {
                    $session->title = 'WNBA League';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 10-13 
                if ($index ==  9) {
                    $session->title = 'Tennessee Titans';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 14-16
                if ($index ==  13) {
                    $session->title = 'Phoenix Rising';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 17
                if ($index ==  16) {
                    $session->title = 'Arizona Diamondbacks';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 18 
                if ($index ==  17) {
                    $session->title = 'Colorado Avalanche';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 19-21 
                if ($index ==  18) {
                    $session->title = 'New York Yankees';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 22-24 
                if ($index ==  21) {
                    $session->title = 'Philadelphia Flyers';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 25-29 
                if ($index ==  24) {
                    $session->title = 'Cleveland Cavaliers';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 30-32 
                if ($index ==  29) {
                    $prev_post = Post::where('title', 'Colorado Avalanche')->first();
                    $display_order = 2;
                }

                // 33-35
                if ($index ==  32) {
                    $session->title = 'Sacramento  Republic';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }
                
                // 36-37
                if ($index ==  35) {
                    $session->title = 'Oregon State University';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                // 38-40
                if ($index ==  37) {
                    $session->title = 'University of Washington';
                    $prev_post = $this->createPost($session);
                    $display_order = 1;
                }

                $this->saveImages($prev_post, $session->image_url, $display_order);

                $display_order++;
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
        Schema::drop('session');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
