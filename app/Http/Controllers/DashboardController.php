<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Assessment;
use App\Models\Kriteria;
use App\Models\Topsis_Result;
use App\Models\TopsisResult;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Disini routing pembeda tampilan dashboard untuk admin dan manager dia akan memilih di dua fungsi dibawah dari fungsi ini
        if(strtolower(auth()->user()->role) === 'admin') {
            return $this->admin();
        }else{
            return $this->manager();
        }

    }



    public function admin()
    {
        $totalAssessments = Assessment::count();
        $totalSuppliers = Supplier::count();
        $totalCriteria = Kriteria::count();
        $activeUsers = User::count();
        
        $recentAssessments = Assessment::withCount('topsisResults')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.dashboard.admin', compact(
            'totalAssessments',
            'totalSuppliers',
            'totalCriteria',
            'activeUsers',
            'recentAssessments'
        ));
    }

    public function manager()
    {
        // Get top performing supplier from latest assessment
        $latestAssessment = Assessment::latest()->first();
        $topSupplier = null;
        $recentResults = collect();
        $totalRatedSuppliers = 0;

        if ($latestAssessment) {
            $topSupplier = Topsis_Result::with('supplier')
                ->where('assessment_id', $latestAssessment->id)
                ->orderBy('rank')
                ->first();

            $recentResults = Topsis_Result::with('supplier')
                ->where('assessment_id', $latestAssessment->id)
                ->orderBy('rank')
                ->take(10)
                ->get();

            $totalRatedSuppliers = $recentResults->count();
        }

        // Monthly statistics
        $monthlyAssessments = Assessment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $averageScore = Topsis_Result::avg('preference_score');
        $activeSuppliers = Supplier::where('status', 'active')->count();

        return view('pages.dashboard.manager', compact(
            'topSupplier',
            'latestAssessment',
            'totalRatedSuppliers',
            'recentResults',
            'monthlyAssessments',
            'averageScore',
            'activeSuppliers'
        ));
    }
}