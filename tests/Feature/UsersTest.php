<?php

namespace Tests\Feature;

use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * Test with empty query
     *
     * @return void
     */
    public function testWithoutQuery()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(200);
    }

    /**
     * Test with query
     *
     * @return void
     */
    public function testWithQuery()
    {
        $response = $this->get('/api/users?query=bla');
        $response->assertStatus(200);
    }
}
