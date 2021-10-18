<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function testItShouldSeeContactPage()
    {
        $response = $this->get(route('store.contact.index'));
        $response->assertStatus(200);
    }
}
