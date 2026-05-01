<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    // Helper
    private function makeUser(Company $company, string $role): User
    {
        return User::factory()->create([
            'company_id' => $company->id,
            'role'       => $role,
        ]);
    }

    // Test 1: Admin can create URL
    public function test_admin_can_create_short_url(): void
    {
        $company = Company::factory()->create();
        $admin   = $this->makeUser($company, 'Admin');

        $this->actingAs($admin)
            ->post(route('urls.store'), ['original_url' => 'https://example.com'])
            ->assertRedirect();

        $this->assertDatabaseHas('short_urls', ['created_by' => $admin->id]);
    }

    // Test 2: Member can create URL
    public function test_member_can_create_short_url(): void
    {
        $company = Company::factory()->create();
        $member  = $this->makeUser($company, 'Member');

        $this->actingAs($member)
            ->post(route('urls.store'), ['original_url' => 'https://example.com'])
            ->assertRedirect();

        $this->assertDatabaseHas('short_urls', ['created_by' => $member->id]);
    }

    // Test 3: SuperAdmin can not create URL
    public function test_superadmin_cannot_create_short_url(): void
    {
        $superAdmin = User::factory()->create(['role' => 'SuperAdmin', 'company_id' => null]);

        $this->actingAs($superAdmin)
            ->post(route('urls.store'), ['original_url' => 'https://example.com'])
            ->assertForbidden();
    }

    // Test 4: Admin can see own company's URLs
    public function test_admin_sees_only_own_company_urls(): void
    {
        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $admin    = $this->makeUser($companyA, 'Admin');
        $other    = $this->makeUser($companyB, 'Admin');

        $ownUrl   = ShortUrl::factory()->create(['company_id' => $companyA->id, 'created_by' => $admin->id]);
        $otherUrl = ShortUrl::factory()->create(['company_id' => $companyB->id, 'created_by' => $other->id]);

        $response = $this->actingAs($admin)->get(route('urls.index'));
        $response->assertSeeText($ownUrl->short_code);
        $response->assertDontSeeText($otherUrl->short_code);
    }

    // Test 5: Member can see own URLs
    public function test_member_sees_only_own_urls(): void
    {
        $company  = Company::factory()->create();
        $member   = $this->makeUser($company, 'Member');
        $other    = $this->makeUser($company, 'Member');

        $myUrl    = ShortUrl::factory()->create(['company_id' => $company->id, 'created_by' => $member->id]);
        $theirUrl = ShortUrl::factory()->create(['company_id' => $company->id, 'created_by' => $other->id]);

        $response = $this->actingAs($member)->get(route('urls.mine'));
        $response->assertSeeText($myUrl->short_code);
        $response->assertDontSeeText($theirUrl->short_code);
    }

    // Test 6: Short URL publicly resolvable
    public function test_short_url_is_publicly_resolvable(): void
    {
        $company  = Company::factory()->create();
        $admin    = $this->makeUser($company, 'Admin');
        $shortUrl = ShortUrl::factory()->create([
            'company_id'   => $company->id,
            'created_by'   => $admin->id,
            'original_url' => 'https://example.com',
            'short_code'   => 'abc1234',
        ]);

        // Resolve 
        $this->get(route('urls.resolve', 'abc1234'))
            ->assertRedirect('https://example.com');
    }
}
