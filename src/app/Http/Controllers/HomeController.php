<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Helpers;
use Arr;
use Settings;


use App\Event;
use App\User;
use App\SliderImage;
use App\NewsArticle;
use App\EventTimetable;
use App\EventTimetableData;
use App\EventParticipant;
use App\EventTournamentTeam;
use App\EventTournamentParticipant;
use App\MatchMaking;
use App\MatchMakingTeam;

use App\Http\Requests;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

use Facebook\Facebook;
use Debugbar;

class HomeController extends Controller
{
    /**
     * Show Index Page
     * @return Function
     */
    public function index()
    {
        // Check for Event
        $user = Auth::user();
        // Is this user a eventParticipants?
        if (empty($user->eventParticipants)) {
            return $this->net();            
        }

        Debugbar::addMessage("User: " . json_encode($user));
        Debugbar::addMessage("Participants: " . json_encode($user->eventParticipants), 'Event');
        
        // Getting the Current Time once
        $currentDateTime = Carbon::now();

        // Loop trough the eventParticipants 
        // The first one, that is active (see def. below) returns the event page
        foreach ($user->eventParticipants as $participant) {
            if ($this->isActiveParticipant($participant, $currentDateTime)) {
                Debugbar::addMessage("Participant gets event", 'Event');
                return $this->event();
            }
        }

        return $this->net();
    }

    /**
     * Determines if a participant is active based on several conditions:
     *  - A Event is currently running
     *  - the participant is signed In or Online Event
     *  - has purchased successful or is free or is staff
     *
     * @param $participant
     * @param $currentDateTime
     * @return bool
     */
    protected function isActiveParticipant($participant, $currentDateTime): bool
    {
        try
        { 
            // Check if current time is within the event's start and end time
            $isWithinEventTime = $currentDateTime >= $participant->event->start &&
                $currentDateTime <= $participant->event->end;

            // Conditions for active participants
            $isActive = ($participant->signed_in || $participant->event->online_event) &&
                ($participant->free || $participant->staff || $participant->purchase->status == "Success");

            return $isWithinEventTime && $isActive;
        } catch (\Exception $e) {
            // Log the error for diagnosis
            Debugbar::addMessage('Error checking participant activity: ' . $e->getMessage(), 'Event');
            
            return false;  // Default value if an exception occurs
        }
    }

    /**
     * Show New Page
     * @return View
     */
    public function net()
    {
        $topAttendees = $this->getTopAttendees();
        $topWinners = $this->getTopWinners();

        $gameServerList = Helpers::getPublicGameServers();

        return view("home")
            ->withNextEvent($this->getNextEvent())
            ->withTopAttendees(array_slice($topAttendees, 0, 5))
            ->withTopWinners(array_slice($topWinners, 0, 5))
            ->withGameServerList($gameServerList)
            ->withNewsArticles($this->getLatestNewsArticles())
            ->withEvents($this->getAllEvents())
            ->withSliderImages(SliderImage::getImages('frontpage'))
        ;
    }

    

     /**
     * Get top attendees by event count.
     *
     * @return array
     */
    protected function getTopAttendees(): array
    {
        $attendees = [];
        foreach (EventParticipant::groupBy('user_id', 'event_id')->get() as $attendee) {
            if (!$attendee->event || $attendee->event->status != 'PUBLISHED' || $attendee->event->end >= Carbon::today()) {
                continue;
            }

            $userId = $attendee->user->id;
            if (!$attendee->user->admin && isset($attendees[$userId])) {
                $attendees[$userId]->event_count++;
            } elseif (!$attendee->user->admin) {
                $attendee->user->event_count = 1;
                $attendees[$userId] = $attendee->user;
            }
        }

        usort($attendees, function ($a, $b) {
            return $b['event_count'] <=> $a['event_count'];
        });

        return $attendees;
    }

    /**
     * Get top winners by win count.
     *
     * @return array
     */
    protected function getTopWinners(): array
    {
        $winners = [];

        // Process winner teams
        foreach (EventTournamentTeam::where('final_rank', 1)->get() as $team) {
            foreach ($team->tournamentParticipants as $participant) {
                $this->updateWinCount($winners, $participant->eventParticipant->user);
            }
        }

        // Process individual winners
        foreach (EventTournamentParticipant::where('final_rank', 1)->get() as $winner) {
            $this->updateWinCount($winners, $winner->eventParticipant->user);
        }

        usort($winners, function ($a, $b) {
            return $b['win_count'] <=> $a['win_count'];
        });

        return $winners;
    }

    /**
     * Update the win count for a given user.
     *
     * @param array $winners
     * @param $user
     */
    protected function updateWinCount(array &$winners, $user): void
    {
        $userId = $user->id;
        if (isset($winners[$userId])) {
            $winners[$userId]->win_count++;
        } else {
            $user->win_count = 1;
            $winners[$userId] = $user;
        }
    }

     /**
     * Get the next upcoming event.
     *
     * @return mixed
     */
    protected function getNextEvent()
    {
        return Event::where('end', '>=', Carbon::now())
            ->orderBy(DB::raw('ABS(DATEDIFF(events.end, NOW()))'))
            ->first();
    }

    /**
     * Get the latest news articles.
     *
     * @return mixed
     */
    protected function getLatestNewsArticles()
    {
        return NewsArticle::limit(2)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get all events.
     *
     * @return mixed
     */
    protected function getAllEvents()
    {
        return Event::all();
    }

    /**
     * Show About us Page
     * @return View
     */
    public function about()
    {
        return view("about");
    }

    /**
     * Show Terms and Conditions Page
     * @return View
     */
    public function terms()
    {
        return view("terms");
    }

    /**
     * Show LegalNotice Page
     * @return View
     */
    public function legalNotice()
    {
        return view("legalnotice");
    }

    /**
     * Show Contact Page
     * @return View
     */
    public function contact()
    {
        return view("contact");
    }

    /**
     * Show Event Page
     * @return View
     */
    public function event()
    {
        $signedIn = true;
        $gameServerList = Helpers::getCasualGameServers();
        
         // Using Carbon for date manipulations
         $now = Carbon::now();
         $event = Event::where('start', '<', $now)->where('end', '>', $now)->orderBy('id', 'desc')->first();

         // Check if event is null and handle it
        if (!$event) {
            return redirect()->route('home.index')->with('error', 'No active event found.');
        }

        // Loading can be done like this in one call of load function
        $event->load(
            'eventParticipants.user', 
            'timetables'
        );
        
        foreach ($event->timetables as $timetable) {
            $timetable->data = EventTimetableData::where('event_timetable_id', $timetable->id)
                ->orderBy('start_time', 'asc')
                ->get();
        }

        // TODO - Refactor
        $user = Auth::user();
        if ($user) {
            $clauses = ['user_id' => $user->id, 'event_id' => $event->id];
            $user->eventParticipation = EventParticipant::where($clauses)->get();
        }

        $ticketFlagSignedIn = false;
        if ($user) {
            $user->setActiveEventParticipant($event);
            if ($user->eventParticipation != null || isset($user->eventParticipation)) {
                foreach ($user->eventParticipation as $participant) {
                    if ($participant->event_id == $event->id) {
                        $ticketFlagSignedIn = true;
                    }
                }
            }
        }

        $currentuser                  = Auth::id();
        $openpublicmatches = MatchMaking::where(['ispublic' => 1, 'status' => 'OPEN'])->orderByDesc('created_at')->paginate(4, ['*'], 'openpubmatches');
        // $liveclosedpublicmatches = MatchMaking::where(['ispublic' => 1, 'status' => 'WAITFORPLAYERS'])->orWhere(['ispublic' => 1, 'status' => 'LIVE'])->orWhere(['ispublic' => 1, 'status' => 'COMPLETE'])->orderByDesc('created_at')->paginate(4, ['*'], 'closedpubmatches');
        $liveclosedpublicmatches = MatchMaking::where(function ($query) {
            $query->where('ispublic', 1);
            $query->where('status', 'WAITFORPLAYERS');
        })->orWhere(function ($query) {
            $query->where('ispublic', 1);
            $query->where('status', 'LIVE');
        })->orWhere(function ($query) {
            $query->where('ispublic', 1);
            $query->where('status', 'COMPLETE');
        })->orderByDesc('created_at')->paginate(4, ['*'], 'closedpubmatches');;
        
        $ownedmatches = MatchMaking::where(['owner_id' => $currentuser])->orderByDesc('created_at')->paginate(4, ['*'], 'owenedpage')->fragment('ownedmatches');
        $memberedteams = Auth::user()->matchMakingTeams()->orderByDesc('created_at')->paginate(4, ['*'], 'memberedmatches')->fragment('memberedmatches');
        $currentuseropenlivependingdraftmatches = array();
        
        foreach (MatchMaking::where(['status' => 'OPEN'])->orWhere(['status' => 'LIVE'])->orWhere(['status' => 'DRAFT'])->orWhere(['status' => 'PENDING'])->get() as $match)
        {
            if ($match->getMatchTeamPlayer(Auth::id()))
            {
                $currentuseropenlivependingdraftmatches[$match->id] = $match->id;
            }
        }

        return view("events.home")
            ->withOpenPublicMatches($openpublicmatches)
            ->withLiveClosedPublicMatches($liveclosedpublicmatches)
            ->withMemberedTeams($memberedteams)
            ->withOwnedMatches($ownedmatches)
            ->withCurrentUserOpenLivePendingDraftMatches($currentuseropenlivependingdraftmatches)
            ->withisMatchMakingEnabled(Settings::isMatchMakingEnabled())
            ->withEvent($event)
            ->withGameServerList($gameServerList)
            ->withTicketFlagSignedIn($ticketFlagSignedIn)
            ->withSignedIn($signedIn)
            ->withUser($user);
    }

    /**
     * Show Big Screen Page
     * @param  Event  $event
     * @return View
     */
    public function bigScreen(Event $event)
    {
        return view("events.big")->withEvent($event);
    }
}
