<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SendWishlistUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:wishlists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send wishlists mail to users';

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
        $users = User::has('wishlists')->with('wishlists')->get();
    }
}
