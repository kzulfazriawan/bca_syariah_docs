<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    //
    public function create(Request $request){
        if (!$request->user()->is_admin){
            $validator = \Validator::make($request->all(), [
                'title' => 'required|string',
                'content' => 'required|string',
            ]);

            if ($validator->fails())
                return response(['errors'=>$validator->errors()->all()], 422);

            $ticket = Ticket::create([
                "title" => $request->input("title"),
                "content" => $request->input("content"),
                "status" => "new",
                "report_id" => $request->user()['id']
            ]);

            return response()->json($ticket->asJson(), 200);
        }
    }

    public function all(Request $request) {
        if (!$request->user()->is_admin){
            return response()->json($ticket = Ticket::where("report_id", $request->user())->get()->toJson(), 200);
        } else {
            return response()->json($ticket = Ticket::all()->toJson(), 200);
        }
    }
}
