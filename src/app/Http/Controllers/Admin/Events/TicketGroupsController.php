<?php

namespace App\Http\Controllers\Admin\Events;

use App\Event;
use App\EventTicketGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;

class TicketGroupsController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $rules = [
            'ticket-group-name'    => 'required',
            'ticket-group-tickets' => 'required|numeric',
        ];
        $messages = [
            'ticket-group-name.required' => 'Ticket group name is required',
            'ticket-group-tickets.numeric' => 'Tickets per user must be a number',
            'ticket-group-tickets.required' => 'Tickets per user is required',
        ];
        $this->validate($request, $rules, $messages);

        $group = new EventTicketGroup();
        $group->event_id = $event->id;
        $group->name = $request->get('ticket-group-name');
        $group->tickets_per_user = $request->get('ticket-group-tickets');

        if (!$group->save()) {
            return Redirect::back();
        }

        Session::flash('alert-success', 'Ticket saved Successfully');
        return Redirect::to("/admin/events/{$event->slug}/tickets");
    }

    public function show(Event $event, EventTicketGroup $ticketGroup) {
        return view('admin.events.ticketgroups.show')
            ->withEvent($event)
            ->withTicketGroup($ticketGroup);
    }
}