<?php

namespace Tests\Feature\Bhabinkamtibmas;

use App\Models\Problem_solving;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProblemSolvingTest extends TestCase
{
    private function getUserBhabinkamtibmas()
    {
        session()->put('personel.nrp', '0000000');
        return User::whereEmail('bhabinkamtibmas@polri.go.id')->first();
    }

    public function test_redirect_unathenticated_user_to_login()
    {
        $response = $this->get(route('problem-solving.sengketa.index'));

        $response->assertRedirect('/login');
    }

    public function test_bhabinkamtibmas_can_access_problem_solving_menu()
    {
        $this->actingAs($this->getUserBhabinkamtibmas())
            ->get('/laporan/problem-solving')
            ->assertStatus(200)
            ->assertSee('Problem Solving');
    }

    public function test_bhabinkamtibmas_can_access_problem_solving_sengketa()
    {
        $this->actingAs($this->getUserBhabinkamtibmas())
            ->get(route('problem-solving.sengketa.index'))
            ->assertStatus(200);
    }

    public function test_bhabinkamtibmas_can_see_tambah_laporan_button()
    {
        $this->actingAs($this->getUserBhabinkamtibmas())
            ->get(route('problem-solving.sengketa.index'))
            ->assertSee("Tambah Laporan");
    }

    public function test_bhabinkamtibmas_can_add_problem_solving_sengketa()
    {
        $this->actingAs($this->getUserBhabinkamtibmas());
        $this->get(route('problem-solving.sengketa.create'))
            ->assertStatus(200)
            ->assertSee('Simpan');
        $response = $this->post(route('problem-solving.sengketa.store'), [
            "_token" => csrf_token(),
            "nama_pihak_1" => "Andre Feature Test",
            "pekerjaan_pihak_1" => "Swasta",
            "provinsi_pihak_1" => "BANTEN",
            "kabupaten_pihak_1" => "KOTA SERANG",
            "kecamatan_pihak_1" => "WALANTAKA",
            "desa_pihak_1" => "Teritih",
            "alamat_pihak_1" => "Alamat Pihak 1",
            "rt_pihak_1" => "1",
            "rw_pihak_1" => "1",
            "nama_pihak_2" => "Yanto",
            "pekerjaan_pihak_2" => "Negri",
            "provinsi_pihak_2" => "DAERAH ISTIMEWA YOGYAKARTA",
            "kabupaten_pihak_2" => "KABUPATEN BANTUL",
            "kecamatan_pihak_2" => "DLINGO",
            "desa_pihak_2" => "Muntuk",
            "alamat_pihak_2" => "Alamat Pihak 2",
            "rt_pihak_2" => "2",
            "rw_pihak_2" => "2",
            "nama_narasumber" => "Manto",
            "pekerjaan_narasumber" => "Pedagang Mie Ayam",
            "alamat_narasumber" => "Tetangga",
            "tanggal" => "2022-05-04",
            "waktu_kejadian" => "16:12",
            "uraian_kejadian" => "Uraian permasalahan probsol harus lebih dari 50 karakter",
            "saksi" => "Manto",
            "hari_masalah_selesai" => "kamis",
            "tanggal_masalah_selesai" => "2022-05-05",
            "uraian_problem_solving" => "Uraian solusi problem solving harus lebih dari 50 karakter",
            "surat_kesepakatan" => UploadedFile::fake()->create('surat-kesepakatan.pdf', 10),
            "penulis" => "Karno Nur Cahyo",
            "polda" => "",
            "user_id" => $this->getUserBhabinkamtibmas()->id,
            "keyword" => [
                "testing", "feature test"
            ]
        ]);
        $response->assertSessionHas([
            "swal_msg" => [
                "title" => "Operasi Sukses",
                "message" => "Berhasil menambahkan laporan problem solving",
                "type" => "success"
            ]
        ]);
        $ps = Problem_solving::latest()->first();
        $this->assertTrue($ps->nama_pihak_1 === "Andre Feature Test");
        $ps->delete();
    }
}
