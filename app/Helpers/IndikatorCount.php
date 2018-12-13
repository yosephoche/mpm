<?php

namespace App\Http\Helpers;

use App\Models\IndikatorVariabel;

class IndikatorCount
{
    //nilai status = 2 => tinggi, 1 => sedang, 0 = rendah
    //#1 kesehatan lain
    public function indiKesehatanLain($value)
    {
        //b5_r6f
        $status = 0;
        if ($value == 2) {
            $status = 2; //tinggi
        }
        return $status;
    }

    //#2 kis/bpjs
    public function indiKisBpjs($valueOne, $valueTwo)
    {
        $status = 1;
        if ($valueOne == 2 && $valueTwo == 2) { //tinggi
            $status = 2;
        } elseif ($valueOne == 1 && $valueTwo == 1) {
            $status = 0;
        }

        return $status;
    }

    //#3 kip
    public function indiKip($value)
    {
        //b5_r6b
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $status;
    }

    //#4 peserta program PKH
    public function indiPesertaPkh($value)
    {
        //b5_k6g
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $status;
    }

    //#5 peserta program KUR
    public function indiPesertaKur($value)
    {
        //b5_k6i
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $value;
    }

    //#6 peserta program rastra
    public function indiPesertaRastra($value)
    {
        //b5_k6h
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $status;
    }

    //#7 peserta kks/kps
    public function indiPesertaKks($value)
    {
        //b5_k6a
        $status = 0;
        if ($value == 1) {
            $status = 2;
        }

        return $status;
    }

    //#8 kelengkapan persuratan
    public function indiKelengkapanPersuratan($valueOne, $valueTwo)
    {
        //b4_k9
        //b4_k11
        $status = 0;
        if ($valueOne == 1 && $valueTwo == 15) { //tinggi
            $status = 2;
        } elseif ($valueOne == 0 && $valueTwo == 0) { //rendah
            $status = 0;
        } else { // sedang
            $status = 1;
        }

        return $status;
    }

    //#9 fasilitas memasak
    public function indiFasilitasMemasak($valueOne, $valueTwo)
    {
        $status = 1;
        if (($valueOne == 1 || $valueOne == 2) && ($valueTwo == 1)) { //tinggi
            $status = 2;
        } elseif (($valueOne == 8 || $valueOne == 9) && $valueTwo == 2) { //rendah
            $status = 0;
        }

        return $status;
    }

    //#11 pekerjaan
    public function indiPekerjaan($value)
    {
        $status = 1;
        if ($value == 1) { //tinggi
            $status = 2;
        } elseif ($value == 2) { //rendah
            $status = 0;
        }

        return $status;
    }

    //#
}
