<?php

namespace Admin\SISLAP\LaporanSubdit\SIPOLSUS;

use Tests\TestCase;

class PolsusTest extends TestCase
{
    public function test_lapsubjar_has_sipolsus_menu()
    {
        $response = $this->actingAs($this->administrator(), 'web')
            ->get(route('lapsubjar'))
            ->assertSee("SI-POLSUS");
    }

    public function test_polsus_has_data_polsus_diklat_reguler_menu()
    {
        $this->actingAs($this->administrator(), 'web');
        /*
         * Check if the menu "Data Polsus Diklat Reguler" is visible and accessible
         */
        $this->get(route('sipolsus'))->assertSee("Data Polsus Diklat Reguler");
        $this->get(route('sipolsus'))->assertSee(route('data-diklat-reguler.index'));
    }

    public function test_polsus_has_data_polsus_diklat_khusus_menu()
    {
        $this->actingAs($this->administrator(), 'web');
        /*
         * Check if the menu "Data Polsus Diklat Khusus" is visible and accessible
         */
        $this->get(route('sipolsus'))->assertSee("Data Polsus Diklat Khusus");
        $this->get(route('sipolsus'))->assertSee(route('data-diklat-khusus.index'));
    }

    public function test_polsus_has_data_polsus_kepemilikan_kta_menu()
    {
        $this->actingAs($this->administrator(), 'web');
        /*
         * Check if the menu "Data Polsus Kepemilikan KTA" is visible and accessible
         */
        $this->get(route('sipolsus'))->assertSee("Data Polsus Kepemilikan KTA");
        $this->get(route('sipolsus'))->assertSee(route('data-kepemilikan-kta.index'));
    }

    public function test_polsus_has_data_senpi_polsus_menu()
    {
        $this->actingAs($this->administrator(), 'web');
        /*
         * Check if the menu "Data Senpi Polsus" is visible and accessible
         */
        $this->get(route('sipolsus'))->assertSee("Data Senpi Polsus");
        $this->get(route('sipolsus'))->assertSee(route('data-senpi.index'));
    }

    public function test_polsus_has_data_amunisi_polsus_menu()
    {
        $this->actingAs($this->administrator(), 'web');
        /*
         * Check if the menu "Data Amunisi Polsus" is visible and accessible
         */
        $this->get(route('sipolsus'))->assertSee("Data Amunisi Polsus");
        $this->get(route('sipolsus'))->assertSee(route('data-amunisi.index'));
    }
}
