<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkSessionResource;
use App\Models\Pcs;
use App\Models\WorkSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class WorkSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(null, 'Not implemented', 501);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->sendResponse(null, 'Not implemented', 501);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workSession = WorkSession::find($id);
        if ($workSession) {
            return $this->sendResponse(WorkSessionResource::make($workSession), 'Work session retrieved successfully');
        }
        return $this->sendResponse(null, 'Work session not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        return $this->sendResponse(null, 'Not implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->sendResponse(null, 'Not implemented', 501);
    }


    /*
    |---------------------------------------------------------------------------------------------|
    |                                           START END                                         |
    |---------------------------------------------------------------------------------------------|
    */

    public function StartEnd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'date_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors()->first(), 400);
        }

        $date = Carbon::parse($request->date_time)->toDateString();

        $workSession = WorkSession::where('user_id', $request->user_id)
            ->whereDate('wkstart_time', $date)
            ->first();

        if ($workSession) {
            if ($workSession->wkstart_time && $workSession->wkend_time) {
                return $this->sendResponse(null, 'Datos del dia ya registrados', 400);
            }

            if (!$workSession->wkend_time) {
                $workSession->wkend_time = $request->date_time;
                $workSession->save();
                $workSession->notifyES();
                return $this->sendResponse(null, 'Salida Exitosa');
            }
        } else {
            $pc_info = $this->getPcInfo($request);
            $workSession = WorkSession::create([
                'user_id' => $request->user_id,
                'pc_work' => $pc_info->id,
                'wkstart_time' => $request->date_time,
            ]);

            if ($workSession) {
                $workSession->notifyES();
                return $this->sendResponse(null, 'Registro Exitoso');
            }
        }
        return $this->sendResponse(null, 'No se pudo registrar', 500);
    }


    public function getWorkSessionsByDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors()->first(), 400);
        }

        $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();

        $workSessions = WorkSession::where('user_id', $request->user_id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('wkstart_time', [$startDate, $endDate])
                    ->orWhereBetween('wkend_time', [$startDate, $endDate]);
            })
            ->get();

        return $this->sendResponse(WorkSessionResource::collection($workSessions), 'Work sessions retrieved successfully');
    }

    /*
    |---------------------------------------------------------------------------------------------|
    |                                   LUNCH START END                                           |
    |---------------------------------------------------------------------------------------------|
    */

    public function lunchStartEnd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'date_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors()->first(), 400);
        }

        $date = Carbon::parse($request->date_time)->toDateString();

        $workSession = WorkSession::where('user_id', $request->user_id)
            ->whereDate('wkstart_time', $date)
            ->first();

        if (!$workSession) {
            return $this->sendResponse(null, 'No se encontró una sesión de trabajo para este día', 400);
        }

        if ($workSession->lunch_start_time && $workSession->lunch_end_time) {
            return $this->sendResponse(null, 'Datos del día ya registrados', 400);
        }

        if ($workSession->lunch_start_time) {

            $workSession->lunch_end_time = $request->date_time;
        } else {
            $workSession->lunch_start_time = $request->date_time;
        }

        $workSession->save();

        if ($workSession) {
            $workSession->notifyES();
            return $this->sendResponse(null, 'Registro Exitoso');
        }

        return $this->sendResponse(null, 'No se pudo registrar', 500);
    }
    private function getPcInfo(Request $request)
    {
        try {
            $DeviceName = $request->header('X-Device-Name');
            $DeviceIp = $request->header('X-Device-Ip');
            $device = Pcs::with('estado')->where('name', $DeviceName)->where('ip', $DeviceIp)->first();
            return $device;
        } catch (Throwable $th) {
            return null;
        }
    }
}