<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Apartment;
use App\Facility;

class FacilityController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'bail|required',
            'equipment' => 'bail|required',
            'nb' => 'bail|required',
            'outline' => 'bail|required',
            'max' => 'bail|required',
        ]);
        $userId = Auth::user()->id;
        $aptId = Auth::user()->aptId;
        $facilityData['userId'] = $userId;
        $facilityData['aptId'] = $aptId;
        $facilityData['name'] = $request->name;
        $facilityData['equipment'] = $request->equipment;
        $facilityData['nb'] = $request->nb;
        $facilityData['max'] = $request->max;
        $facilityData['outline'] = $request->outline;
        $facilityData['upload_file'] = json_encode($request->file);
        
        $facility = Facility::create($facilityData); 

        return response()->json([
            'facility' => $facility
        ], 201);
    }

    public function index(Request $request)
    {
        $aptId = Auth::user()->aptId;
        return Facility::where([['aptId', '=', $aptId]])
                        ->with(['reservationData.userId', 'userId'])
                        ->orderBy('created_at','desc')
                        ->get();
    }
}
