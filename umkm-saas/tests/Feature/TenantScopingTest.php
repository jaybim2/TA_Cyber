<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\Organization;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TenantScopingTest extends TestCase
{
    protected function tearDown(): void
    {
        Auth::logout();
        Inquiry::withoutTenant()->delete();
        Product::withoutTenant()->delete();
        User::query()->delete();
        Organization::withoutTenant()->delete();

        parent::tearDown();
    }

    public function test_relationships_between_models(): void
    {
        $org = Organization::create([
            'name' => 'Toko ABC',
            'slug' => 'toko-abc-rel',
            'category' => 'Kuliner',
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => 'Admin ABC',
            'email' => 'admin_rel@abc.test',
            'password' => 'secret123',
            'role' => 'umkm_admin',
            'organization_id' => $org->id,
        ]);

        $product = Product::create([
            'organization_id' => $org->id,
            'name' => 'Kue Pia',
            'category' => 'Makanan Ringan',
            'price' => 20000,
            'status' => 'Tampil',
        ]);

        $inquiry = Inquiry::create([
            'organization_id' => $org->id,
            'visitor_name' => 'Budi',
            'message' => 'Tanya stok',
            'status' => 'Baru',
        ]);

        // HasMany
        $this->assertCount(1, $org->users);
        $this->assertCount(1, $org->products);
        $this->assertCount(1, $org->inquiries);

        // BelongsTo
        $this->assertEquals($org->id, $user->organization->id);
        $this->assertEquals($org->id, $product->organization->id);
        $this->assertEquals($org->id, $inquiry->organization->id);
    }

    public function test_umkm_admin_queries_are_scoped_to_their_organization(): void
    {
        $orgA = Organization::create([
            'name' => 'Org A',
            'slug' => 'org-a-scope',
            'category' => 'Kuliner',
        ]);

        $orgB = Organization::create([
            'name' => 'Org B',
            'slug' => 'org-b-scope',
            'category' => 'Fashion',
        ]);

        $adminA = User::create([
            'name' => 'Admin A',
            'email' => 'admina_scope@test.local',
            'password' => 'secret123',
            'role' => 'umkm_admin',
            'organization_id' => $orgA->id,
        ]);

        $prodA = Product::create([
            'organization_id' => $orgA->id,
            'name' => 'Produk A',
            'category' => 'Kuliner',
            'price' => 10000,
        ]);

        $prodB = Product::create([
            'organization_id' => $orgB->id,
            'name' => 'Produk B',
            'category' => 'Fashion',
            'price' => 50000,
        ]);

        $inqA = Inquiry::create([
            'organization_id' => $orgA->id,
            'visitor_name' => 'Visitor A',
            'message' => 'Pesan A',
        ]);

        $inqB = Inquiry::create([
            'organization_id' => $orgB->id,
            'visitor_name' => 'Visitor B',
            'message' => 'Pesan B',
        ]);

        Auth::setUser($adminA);

        // Products isolated
        $products = Product::all();
        $this->assertCount(1, $products);
        $this->assertEquals($prodA->id, $products->first()->id);
        $this->assertNull(Product::find($prodB->id));

        // Inquiries isolated
        $inquiries = Inquiry::all();
        $this->assertCount(1, $inquiries);
        $this->assertEquals($inqA->id, $inquiries->first()->id);
        $this->assertNull(Inquiry::find($inqB->id));

        // Organizations isolated
        $orgs = Organization::all();
        $this->assertCount(1, $orgs);
        $this->assertEquals($orgA->id, $orgs->first()->id);
    }

    public function test_vendor_can_view_all_organizations_but_no_inquiries(): void
    {
        $orgA = Organization::create([
            'name' => 'Org A',
            'slug' => 'org-a-vendor',
            'category' => 'Kuliner',
        ]);

        $orgB = Organization::create([
            'name' => 'Org B',
            'slug' => 'org-b-vendor',
            'category' => 'Fashion',
        ]);

        $vendor = User::create([
            'name' => 'Vendor User',
            'email' => 'vendor_scope@test.local',
            'password' => 'secret123',
            'role' => 'vendor',
            'organization_id' => null,
        ]);

        Inquiry::create([
            'organization_id' => $orgA->id,
            'visitor_name' => 'Visitor A',
            'message' => 'Pesan A',
        ]);

        Auth::setUser($vendor);

        // Vendor sees all UMKM
        $this->assertGreaterThanOrEqual(2, Organization::all()->count());

        // Vendor cannot read inquiry messages
        $this->assertCount(0, Inquiry::all());

        // Vendor can see aggregate counts
        $this->assertGreaterThanOrEqual(1, Inquiry::aggregateCount());
    }
}
