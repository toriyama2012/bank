<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Branch;

class RoutingTest extends TestCase
{
    /**
     * Test the entry point
     *
     * @test
     *
     * @return void
     */
    public function test_entrypoint()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test non logged access to dashboard
     *
     * @test
     *
     * @return void
     */
    public function test_non_logged_user_access_to_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Test logged access to dashboard
     *
     * @test
     *
     * @return void
     */
    public function test_logged_user_access_to_dashboard()
    {
        $user = User::factory()->create();


        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test non logged access to branches
     *
     * @test
     *
     * @return void
     */
    public function test_non_logged_user_access_to_branches()
    {
        $response = $this->get('/branches');

        $response->assertRedirect('/login');
    }

    /**
     * Test logged access to branches
     *
     * @test
     *
     * @return void
     */
    public function test_logged_user_access_to_branches()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/branches');

        $response->assertStatus(200);
    }

    /**
     * Test non logged access to branch customers
     *
     * @test
     *
     * @return void
     */
    public function test_non_logged_user_access_to_branch_customers()
    {   
        $branch = Branch::factory()->create();

        $response = $this->get('/branches/'.$branch->id.'/customer');

        $response->assertRedirect('/login');
    }

    /**
     * Test logged access to branch customers
     *
     * @test
     *
     * @return void
     */
    public function test_logged_user_access_to_branch_customers()
    {
        $user = User::factory()->create();

        $branch = Branch::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/branches/'.$branch->id.'/customer');

        $response->assertStatus(200);
    }

    /**
     * Test non logged access to transfers
     *
     * @test
     *
     * @return void
     */
    public function test_non_logged_user_access_to_transfers()
    {
        $response = $this->get('/transfers');

        $response->assertRedirect('/login');
    }

    /**
     * Test logged access to transfers
     *
     * @test
     *
     * @return void
     */
    public function test_logged_user_access_to_transfers()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/transfers');

        $response->assertStatus(200);
    }

    /**
     * Test non logged access to reports
     *
     * @test
     *
     * @return void
     */
    public function test_non_logged_user_access_to_reports()
    {
        $response = $this->get('/reports');

        $response->assertRedirect('/login');
    }

    /**
     * Test logged access to reports
     *
     * @test
     *
     * @return void
     */
    public function test_logged_user_access_to_reports()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/reports');

        $response->assertStatus(200);
    }

    /**
     * Test logged access to first report
     *
     * @test
     *
     * @return void
     */
    public function test_logged_user_access_to_first_report()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/reports/branch-highest-balances');

        $response->assertStatus(200);
    }

    /**
     * Test logged access to second report
     *
     * @test
     *
     * @return void
     */
    public function test_logged_user_access_to_second_report()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/reports/branch-more-two-customers-and-balance-over-50k');

        $response->assertStatus(200);
    }

    /**
     * Test logged access to second report v2
     *
     * @test
     *
     * @return void
     */
    public function test_logged_user_access_to_second_report_v2()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/reports/branch-more-two-customers-and-balance-over-50k-v2');

        $response->assertStatus(200);
    }
}
