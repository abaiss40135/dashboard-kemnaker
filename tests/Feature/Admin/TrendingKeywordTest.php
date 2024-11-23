<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Tests\TestCase;

class TrendingKeywordTest extends TestCase
{
    public function test_administrator_can_access_trending_keyword_menu()
    {
        $user = User::where('email', 'admin@bospolri.go.id')->first();

        $this->actingAs($user, 'web')
            ->get(route('dashboard.keyword-laporan.index'))
            ->assertSee('Kata Kunci Informasi');
    }

    public function test_administrator_can_access_trending_keyword_datatable()
    {
        $user = User::where('email', 'admin@bospolri.go.id')->first();
        $this->actingAs($user, 'web')
            ->get(route('dashboard.keyword-laporan.datatable', [
                "draw"      => 1,
                "start"     => 0,
                "length"    => 10
            ]))
            ->assertStatus(200);
    }
}

