<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    public function testItShouldSeeBlogPage()
    {
        $response = $this->get(route('store.blog.index'));
        $response->assertStatus(200);
    }
}
