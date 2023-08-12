<?php

namespace Tests\Feature;

use Tests\TestCase;

class RootTest extends TestCase {
    /**
     * @test
     * @testdox It should show application information
     * @return void
     */
    public function applicationInfo(): void {
        $this->get(route('information'))
            ->assertOk()
            ->assertJsonStructure([
                'title',
                'version',
                'timestamp'
            ]);
    }
}
