<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Result::get();
        $result_view = "";
        foreach ($results as $result) {
            $detail = unserialize($result->detail);
            foreach ($detail as $letter => $digit) {
                $result_view .= $letter . " = " . $digit . ", ";
            }
            $result_view .= " iteration = " . $result->iteration;
            $result_view .= "<br>";
        }

        return view('welcome', ['result_view' => $result_view]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $solutions = $this->solveProblem();

        if (empty($solutions)) {
            echo "No Solution";
            return false;
        }

        $data = [];
        foreach ($solutions as $iteration => $solution) {
            $data[] = [
                'iteration' => $iteration,
                'detail' => serialize($solution)
            ];
        }

        if (empty($data)) {
            echo "No data to input";
            return false;
        }

        try {
            Result::insert($data);
            echo "results are inserted successfully";
        } catch (\Exception $e) {
            echo "error with insertion";
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        //
    }

    private function solveProblem()
    {
        // HIER + GIBT + ES = NEUES
        $iteration = 0;
        $results = [];

        // loop 10 times for 10 unique characters.
        for ($h = 1; $h <= 9; $h++) {

            for ($i = 0; $i <= 9; $i++) {
                // skip if characters are same.
                if (in_array($i, [$h])) {
                    continue;
                }

                for ($e = 0; $e <= 9; $e++) {
                    if (in_array($e, [$h, $i])) {
                        continue;
                    }

                    for ($r = 0; $r <= 9; $r++) {
                        if (in_array($r, [$h, $i, $e])) {
                            continue;
                        }

                        for ($g = 1; $g <= 9; $g++) {
                            if (in_array($g, [$h, $i, $e, $r])) {
                                continue;
                            }

                            for ($b = 0; $b <= 9; $b++) {
                                if (in_array($b, [$h, $i, $e, $r, $g])) {
                                    continue;
                                }

                                for ($t = 0; $t <= 9; $t++) {
                                    if (in_array($t, [$h, $i, $e, $r, $g, $b])) {
                                        continue;
                                    }

                                    for ($s = 0; $s <= 9; $s++) {
                                        if (in_array($s, [$h, $i, $e, $r, $g, $b, $t])) {
                                            continue;
                                        }

                                        for ($n = 0; $n <= 9; $n++) {
                                            if (in_array($n, [$h, $i, $e, $r, $g, $b, $t, $s])) {
                                                continue;
                                            }

                                            for ($u = 0; $u <= 9; $u++) {
                                                if (in_array($u, [$h, $i, $e, $r, $g, $b, $t, $s, $n])) {
                                                    continue;
                                                }

                                                // multiple with 10000, 1000, 100, 10 for positions
                                                $hier = ($h * 1000) + ($i * 100) + ($e * 10) + $r;
                                                $gibt = ($g * 1000) + ($i * 100) + ($b * 10) + $t;
                                                $es = ($e * 10) + $s;
                                                $neues = ($n * 10000) + ($e * 1000) + ($u * 100) + ($e * 10) + $s;

                                                if ($hier + $gibt + $es === $neues) {
                                                    $result[$iteration] =
                                                    [
                                                        'H' => $h,
                                                        'I' => $i,
                                                        'E' => $e,
                                                        'R' => $r,
                                                        'G' => $g,
                                                        'B' => $b,
                                                        'T' => $t,
                                                        'S' => $s,
                                                        'N' => $n,
                                                        'U' => $u,
                                                    ];
                                                }

                                                $iteration++;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }
}
