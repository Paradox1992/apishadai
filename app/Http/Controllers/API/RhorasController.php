<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RhorasResource;
use App\Models\Rhoras;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class RhorasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rhoras = Rhoras::all();
        return $this->sendResponse(RhorasResource::collection($rhoras), 'Rhoras retrieved successfully.');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->validData($request)) {
            return $this->sendError('Validation Error.', $this->validData($request));
        } else {
            $rhoras = Rhoras::create($request->all());
            if ($rhoras) {
                return $this->sendResponse(null, 'Rhoras created successfully.');
            }
            return $this->sendError('Rhoras not created.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rhoras = Rhoras::find($id);
        if ($rhoras) {
            return $this->sendResponse(new RhorasResource($rhoras), 'Rhoras retrieved successfully.');
        }
        return $this->sendError('Rhoras not found.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function validData($request)
    {
        $validator = Validator::make($request->all(), [
            'usuario' => 'required',
            'device' => 'required',
            'entrada' => 'required',
        ]);
        return $validator->fails();
    }

    // find data by userId
    public function finduser($userId)
    {
        $rhoras = Rhoras::where('usuario', $userId)->get();
        if ($rhoras) {
            return $this->sendResponse(RhorasResource::collection($rhoras), 'Rhoras retrieved successfully.');
        }
        return $this->sendError('Rhoras not found.');
    }

    // find data by unserId and  date beetween from Request.
    /**
     * Find data by userId and date between from Request.
     */
    public function bydate(int $userId, Request $request)
    {
        $dateFrom = $request->input('startDate');
        $dateTo = $request->input('endDate');

        $rules = [
            'userId' => 'required',
            'dateFrom' => 'required|before:dateTo',
            'dateTo' => 'required|after:dateFrom',
        ];

        $validator = Validator::make(compact('userId', 'dateFrom', 'dateTo'), $rules);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $dateFrom = Carbon::parse($dateFrom)->startOfDay();
        $dateTo = Carbon::parse($dateTo)->endOfDay();

        $rhoras = Rhoras::where('usuario', $userId)
            ->whereBetween('entrada', [$dateFrom, $dateTo])
            ->get();

        if ($rhoras->isNotEmpty()) {
            return $this->sendResponse(RhorasResource::collection($rhoras), 'Rhoras retrieved successfully.');
        }

        return $this->sendError('Rhoras data not found.');
    }

}