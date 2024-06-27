<?php

namespace App\Http\Controllers;
use App\Models\UserData;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        $data = new UserData();
        $data->user_id = auth()->id();
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->save();

        return response()->json($data);
    }

    public function index()
    {
        $data = UserData::where('user_id', auth()->id())->get();
        return response()->json($data);
    }
}

