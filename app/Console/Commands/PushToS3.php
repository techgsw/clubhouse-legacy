<?php

namespace App\Console\Commands;

use App\Image;
use App\Providers\ImageServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class PushToS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:pushToS3 {image_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push images to S3.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('image_id')) {
            $id = (int)$this->argument('image_id');
            $images = Image::where('id', $id);
            if ($images->count() == 0) {
                echo "Image $id not found\n";
            }
            if ($images->get()[0]->cdn) {
                echo "Image $id has already been uploaded\n";
                return;
            }
        } else {
            $images = Image::where('cdn', false);
            $count = $images->count();
            echo "Found $count images not uploaded to S3.\n";
        }

        ImageServiceProvider::pushToS3($images, function ($image) {
            echo "Image ".$image->id." complete\n";
        });
    }
}
