<?php


namespace App\Http\Traits;


trait SweetAlertTrait
{
    public function flashSuccess($message) {
        $this->setupFlash("Operasi Sukses", $message, 'success');
    }

    public function flashError($message) {
        $this->setupFlash("Ada error", $message, 'error');
    }

    public function flashWarning($message) {
        $this->setupFlash("Perhatian", $message, 'warning');
    }

    private function setupFlash($title, $message, $type) {
        request()->session()->flash('swal_msg', [
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);
    }
}
