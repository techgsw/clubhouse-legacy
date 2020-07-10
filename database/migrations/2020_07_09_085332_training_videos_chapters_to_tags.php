<?php

use App\Product;
use App\Tag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrainingVideosChaptersToTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $training_videos = Product::with('options')->whereHas('tags', function($query) {
            $query->where('name', 'Training Video');
        })->get();

        foreach($training_videos as $video) {
            foreach ($video->options as $option) {
                $tag = Tag::where('name', $option->description)->first();
                if (is_null($tag)) {
                    $tag = Tag::create([
                        'name' => $option->description,
                        'slug' => preg_replace("/(\s+)/", "-", strtolower($option->description))
                    ]);
                }

                $video->tags()->save($tag);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // needs to be done manually, technically this is backwards compatible with the old chapter functionality
    }
}
