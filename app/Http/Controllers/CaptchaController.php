<?php

namespace App\Http\Controllers;

class CaptchaController extends Controller
{
    public function getCaptcha()
    {
        $text = $this->random(3);
        $font = public_path('fonts/arialbd.ttf');
        $color = $this->hexToRGB('f39910');
        $width = 150;
        $height = 50;
        $size = $height * 0.6;

        $image = imagecreatetruecolor($width, $height);
        $color = imagecolorallocate($image, $color['r'], $color['g'], $color['b']);

        $bg = $this->hexToRGB('ffffff');
        $bg = imagecolorallocate($image, $bg['r'], $bg['g'], $bg['b']);

        imagefill($image, 0, 0, $bg);
        [$x, $y] = array_values($this->ImageTTFCenter($image, $text, $font, $size));

        $printed = '';
        $ys = [];

        foreach (str_split($text) as $char) {
            $angle = rand(-6, 6);
            $box  = imagettftext($image, $size, $angle, $x, $y, $color, $font, $char);
            $x    = $box[2] + 10;
            $ys[] = $y;
            $y    = rand($height * 0.7, $height * 0.9);
            $printed .= $char;
        }

        imagejpeg($image, NULL, 90);
        header('Content-Type: image/jpeg');
        imagedestroy($image);

        if (session()->has('captcha')) session()->forget('captcha');

        session()->put('captcha', $text);
    }

    private function hexToRGB($color)
    {
        if ($color[0] == '#') $color = substr($color, 1);

        if (strlen($color) == 6) {
            list($r, $g, $b) = [
                $color[0].$color[1],
                $color[2].$color[3],
                $color[4].$color[5]
            ];
        } elseif (strlen($color) == 3) {
            list($r, $g, $b) = [
                $color[0].$color[0],
                $color[1].$color[1],
                $color[2].$color[2]
            ];
        } else {
            return false;
        }

        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);

        return ['r' => $r, 'g' => $g, 'b' => $b];
    }

    private function ImageTTFCenter($image, $text, $font, $size, $angle = 8): array
    {
        $xi  = imagesx($image);
        $yi  = imagesy($image);
        $box = imagettfbbox($size, $angle, $font, $text);
        $xr  = abs(max($box[2], $box[4]))+5;
        $yr  = abs(max($box[5], $box[7]));
        $x   = intval(($xi - $xr) / 2);
        $y   = intval(($yi + $yr) / 2);

        $box = imagettfbbox($size, $angle, $font, $text);
        $xr  = abs(max($box[2], $box[4]))+5;
        $x   = intval(($xi - $xr) / 2.5);

        return ['x' => $x, 'y' => $y];
    }

    private function random($length) {
        $chars = '0123456789';
        $charsLength = strlen($chars);
        $rndStr = '';

        for ($i = 0; $i < $length; $i++) {
            $rndStr .= $chars[rand(0, $charsLength - 1)];
        }

        return $rndStr;
    }
}
