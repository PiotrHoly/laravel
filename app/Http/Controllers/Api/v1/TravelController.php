<?php


namespace App\Http\Controllers\Api\v1;

use App\Models\Travel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use Illuminate\Support\Facades\DB;

class TravelController extends Controller
{
    public function index(Request $request)
    {
        $query = Travel::query();

        // Sprawdź, czy żądanie zawiera parametr 'name' i zastosuj filtr
        if ($request->has('name')) {
            $nameFilter = $request->input('name');
            $query->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($nameFilter) . '%');
        }

        // Sprawdź, czy żądanie zawiera parametr 'number_of_days' i zastosuj filtr
        if ($request->has('number_of_days')) {
            $daysFilter = $request->input('number_of_days');
            $query->where('number_of_days', '>=', $daysFilter);
        }

        // Sprawdź, czy żądanie zawiera parametr 'number_of_nights' i zastosuj filtr
        if ($request->has('number_of_nights')) {
            $nightsFilter = $request->input('number_of_nights');
            $query->where('number_of_nights', '>=', $nightsFilter);
        }
        // Pobierz wyniki
        $travels = $query->get();

        // Zwróć wyniki jako zasoby TravelResource
        $travelResources = TravelResource::collection($travels);
        
    }
}