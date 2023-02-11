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

            return response()->json($ticket, 200);
        }
    }

    public function all(Request $request) {
        if (!$request->user()->is_admin){
            return response()->json(
                Ticket::where("ticket_id", null)
                        ->where("report_id", $request->user()['id'])
                        ->get(),
                200);
        } else {
            return response()->json(
                Ticket::where("ticket_id", null)
                    ->get(),
                200);
        }
    }

    public function reply($id, Request $request) {
        $validator = \Validator::make($request->all(), [
            "content" => "required|string",
        ]);

        if ($validator->fails())
            return response(['errors'=>$validator->errors()->all()], 422);

        $ticket = Ticket::create([
            "title" => "reply ticket ". $id,
            "ticket_id" => $id,
            "content" => $request->input("content"),
            "status" => "new",
            "report_id" => $request->user()['id']
        ]);

        return response()->json($ticket, 200);

    }

    public function detail($id){
        $ticket = Ticket::where("id", $id)->first();
        $reply  = Ticket::where("ticket_id", $id)->get();

        return response()->json(collect(["ticket" => $ticket, "reply" => $reply]), 200);
    }
}
