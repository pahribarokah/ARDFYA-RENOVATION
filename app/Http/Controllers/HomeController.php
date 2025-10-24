<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // No middleware required for public routes
    }

    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        // Get featured services
        $services = Service::where('is_active', true)
                        ->take(6)
                        ->get();

        // Get featured portfolios for homepage
        $featuredPortfolios = \App\Models\Portfolio::active()
                                 ->featured()
                                 ->ordered()
                                 ->limit(3)
                                 ->get();

        // If no featured portfolios, get latest active portfolios
        if ($featuredPortfolios->isEmpty()) {
            $featuredPortfolios = \App\Models\Portfolio::active()
                                     ->ordered()
                                     ->limit(3)
                                     ->get();
        }

        return view('home.index', compact('services', 'featuredPortfolios'));
    }
    
    /**
     * Show the about page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about(): View
    {
        return view('home.about');
    }
    
    /**
     * Show the portfolio page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function portfolio(): View
    {
        // Get all active portfolios ordered by ordering and created_at
        $portfolios = \App\Models\Portfolio::active()
                        ->ordered()
                        ->get();

        // Get unique categories for filter buttons
        $categories = \App\Models\Portfolio::active()
                        ->pluck('category')
                        ->unique()
                        ->values();

        return view('home.portfolio', compact('portfolios', 'categories'));
    }

    /**
     * Show portfolio detail page.
     *
     * @param \App\Models\Portfolio $portfolio
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function portfolioDetail(\App\Models\Portfolio $portfolio): View
    {
        // Only show active portfolios to public
        if (!$portfolio->is_active) {
            abort(404);
        }

        // Get related portfolios (same category, excluding current)
        $relatedPortfolios = \App\Models\Portfolio::active()
                                ->where('category', $portfolio->category)
                                ->where('id', '!=', $portfolio->id)
                                ->ordered()
                                ->limit(3)
                                ->get();

        return view('home.portfolio-detail', compact('portfolio', 'relatedPortfolios'));
    }

    /**
     * Show the contact page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact(): View
    {
        return view('home.contact');
    }
}
