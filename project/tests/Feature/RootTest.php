<?php

namespace Tests\Feature;

use Tests\TestCase;

class RootTest extends TestCase {
    /**
     * @test
     * @testdox It should show root
     * @return void
     */
    public function show(): void {
        $this->get(route('api'))
            ->assertOk()
            ->assertJsonStructure([
                'title',
                'version',
                'timestamp'
            ]);
    }
}
