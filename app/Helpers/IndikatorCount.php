<?php

namespace App\Helpers;

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
        //b5_r6c
        //b5_r6d
        $status = 1;
        if ($valueOne == 1 && $valueTwo == 2) { //tinggi
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
        //b3_k10
		//b5_k1a
        $status = 1;
        if (($valueOne == 1 || $valueOne == 2) && ($valueTwo == 1)) { //tinggi
            $status = 2;
        } elseif (($valueOne == 8 || $valueOne == 9) && $valueTwo == 2) { //rendah
            $status = 0;
        }

        return $status;
    }

    //#10 fasilitas MCK
    public function indiFasilitasMck($valueOne)
    {
        //b3_k11a -> hanya di cek
        $status = 0; //rendah
        if ($valueOne == 1) {
            $status = 2; //tinggi
        } elseif ($valueOne == 2) {
            $status = 1; //sedang
        } elseif ($valueOne == 3 || $valueOne == 4) {
            $status = 0; //rendah
        }

        return $status;
    }

    //#11 pekerjaan
    public function indiPekerjaan($value)
    {
        //on individu
        //b4_k19a
        $status = 1;
        if ($value == 1) { //tinggi
            $status = 2;
        } elseif ($value == 2) { //rendah
            $status = 0;
        }

        return $status;
    }

    //#12 pendidikan
    public function indiPendidikan($valueOne, $valueTwo, $valueThree, $valueFour)
    {
        //b4_k15
        //b4_k16
        //b4_k17
        //b4_k18
        if ($valueOne == 2) {
            //cek variabel indikator yang lain
            if ($valueTwo == 10 && $valueThree == 10 && $valueFour == 10) {
                $status = 2;
            } elseif ($valueTwo = $valueThree = $valueFour == 7 || $valueTwo = $valueThree = $valueFour == 8 || $valueTwo = $valueThree = $valueFour == 9) {
                $status = 1;
            } else {
                $status = 0;
            }
        } else {
            $status = 0;
        }

        return $status;
    }

    //#13 kesehatan
    public function indiKesehatan($valueOne, $valueTwo)
    {
        //b4_k13
        //b4_k14
        $status = 0; //rendah
        if ($valueOne == 0 && $valueTwo == 0) {
            $status = 2; //tinggi
        }

        return $status;
    }

    //#14 listrik
    public function indiListrik($valueOne, $valueTwo)
    {
        //b3_k9a
        //b3_k9b
        $status = 0; //rendah
        if ($valueOne == 1) {
            $status = 2;
        } elseif ($valueOne == 2) {
            $status = 1;
        } elseif ($valueOne == 3) {
            $status = 0;
        }

        return $status;
    }

    //#15 rumah
    public function indiRumah($valueOne, $valueTwo, $valueThree, $valueFour)
    {
        //b3_k1a
        //b3_k1b
        //b3_k3
        //b3_k4a
        if ($valueOne == 1 && $valueTwo == 1) {
            //cek variabel indikator yang lain
            if (($valueThree == 1 || $valueThree == 2 || $valueThree == 3 || $valueThree == 4) && ($valueFour == 1 || $valueFour == 2)) {
                $status = 2; //tinggi
            } else {
                $status = 0; //rendah
            }
        } else {
            $status = 1; //sedang
        }

        return $status;
    }

    //main function
    public function getAllIndikatorvalue($data)
    {
        $result['status'] = 0;
        $result['data'] = '';
        $result['message'] = '';
        //steps :
        //do selection if the data value is empty
        if (!empty($data)) {
            //split data value to call indicator function

    
            //check if the data of each indicator is empty or not, handle it
    
            //formatting result
    
            //return result
            $result['message'] = 'Data is not empty';
            
        } else {
            $result['message'] = 'Data passing are empty';
        }

        return $result;
    }
}
