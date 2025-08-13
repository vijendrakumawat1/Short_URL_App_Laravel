<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Create users for each role
        $this->superAdmin = User::factory()->create(['role' => 'SuperAdmin']);
        $this->admin = User::factory()->create(['role' => 'Admin', 'company_id' => 1]);
        $this->member = User::factory()->create(['role' => 'Member', 'company_id' => 1]);
        $this->sales = User::factory()->create(['role' => 'Sales', 'company_id' => 1]);
        $this->manager = User::factory()->create(['role' => 'Manager', 'company_id' => 1]);
    }

    public function test_superadmin_cannot_create_short_url()
    {
        $this->actingAs($this->superAdmin);
        $response = $this->post(route('shorturls.store'), ['long_url' => 'https://example.com']);
        $response->assertForbidden();
    }

    public function test_admin_cannot_create_short_url()
    {
        $this->actingAs($this->admin);
        $response = $this->post(route('shorturls.store'), ['long_url' => 'https://example.com']);
        $response->assertForbidden();
    }

    public function test_member_cannot_create_short_url()
    {
        $this->actingAs($this->member);
        $response = $this->post(route('shorturls.store'), ['long_url' => 'https://example.com']);
        $response->assertForbidden();
    }

    public function test_sales_can_create_short_url()
    {
        $this->actingAs($this->sales);
        $response = $this->post(route('shorturls.store'), ['long_url' => 'https://example.com']);
        $response->assertRedirect(route('shorturls.index'));
    }

    public function test_manager_can_create_short_url()
    {
        $this->actingAs($this->manager);
        $response = $this->post(route('shorturls.store'), ['long_url' => 'https://example.com']);
        $response->assertRedirect(route('shorturls.index'));
    }

    public function test_admin_can_only_see_short_urls_not_in_own_company()
    {
        $otherAdmin = User::factory()->create(['role' => 'Admin', 'company_id' => 2]);
        $url = ShortUrl::factory()->create(['user_id' => $otherAdmin->id, 'company_id' => 2]);
        $this->actingAs($this->admin);
        $response = $this->get(route('shorturls.index'));
        $response->assertSee($url->long_url);
    }

    public function test_member_can_only_see_short_urls_not_created_by_themselves()
    {
        $otherMember = User::factory()->create(['role' => 'Member', 'company_id' => 1]);
        $url = ShortUrl::factory()->create(['user_id' => $otherMember->id, 'company_id' => 1]);
        $this->actingAs($this->member);
        $response = $this->get(route('shorturls.index'));
        $response->assertSee($url->long_url);
    }

    public function test_short_urls_are_not_publicly_resolvable()
    {
        $url = ShortUrl::factory()->create(['user_id' => $this->sales->id, 'company_id' => 1]);
        $response = $this->get(route('shorturls.redirect', ['code' => $url->short_code]));
        $response->assertForbidden();
    }
}
