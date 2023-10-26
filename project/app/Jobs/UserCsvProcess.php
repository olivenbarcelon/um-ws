<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Repositories\UserRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UserCsvProcess implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;
    public $userRepository;

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct(array $data, array $header, UserRepository $userRepository) {
        $this->data   = $data;
        $this->header = $header;
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle() {
        foreach($this->data as $user) {
            $userData = array_combine($this->header, $user);
            $this->userRepository->save($userData);
        }
    }
}
