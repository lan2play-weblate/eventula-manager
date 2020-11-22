<?php

namespace App\Http\Controllers\Api\GameMatchApi;

use DB;
use Auth;

use App\Event;
use App\EventTournament;
use App\EventTimetable;
use App\EventTimetableData;
use App\EventParticipant;
use App\EventParticipantType;
use App\EventTournamentMatchServer;
use App\GameMatchApiHandler;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MatchMaking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GameMatchApiController extends Controller
{
    /**
     * tournamentMatchConfig
     * @return View
     */
    public function tournamentMatchConfig(Event $event, EventTournament $tournament, int $challongeMatchId, int $nummaps)
    {
        $match = $tournament->getMatch($challongeMatchId);
        if (!$match) {
            return "No Match found for $challongeMatchId";
        }
        if (isset($tournament->game) && isset($tournament->game->gamematchapihandler)) 
        {
            $gamematchapihandler = (new GameMatchApiHandler())->getGameMatchApiHandler($tournament->game->gamematchapihandler);
            
            $team1 = $tournament->getTeamByChallongeId($match->player1_id);
            $team2 = $tournament->getTeamByChallongeId($match->player2_id);

            $gamematchapihandler->addteam($team1->name);
            $gamematchapihandler->addteam($team2->name);

            foreach ($team1->tournamentParticipants as $key => $team1Participant) {
                $eventParticipant = $team1Participant->eventParticipant;
                $user = $eventParticipant->user;
                $gamematchapihandler->addplayer($team1->name, $user->steamid, $user->steamname, $user->id, $user->username);
            }
            foreach ($team2->tournamentParticipants as $key => $team2Participant) {
                $eventParticipant = $team2Participant->eventParticipant;
                $user = $eventParticipant->user;
                $gamematchapihandler->addplayer($team2->name, $user->steamid, $user->steamname, $user->id, $user->username);
            }

            $result = $gamematchapihandler->start($challongeMatchId, $nummaps, $tournament->team_size[0]);
            $matchserver = EventTournamentMatchServer::getTournamentMatchServer($challongeMatchId);

            if (isset($matchserver->gameServer->gameserver_secret) && $tournament->game->matchmaking_autofinalize)
            {
                $finalizeurl = config('app.url')."/api/events/".$tournament->event->slug."/tournaments/".$tournament->slug."/".$challongeMatchId."/finalize";
                $result = $gamematchapihandler->start($challongeMatchId, $nummaps, $tournament->team_size[0],$finalizeurl, $matchserver->gameServer->gameserver_secret);
            }
            else
            {
                $result = $gamematchapihandler->start($challongeMatchId, $nummaps, $tournament->team_size[0], null, null);
            }

        }
        else
        {
            return "no gamematchapihandler for match available!";
        }


        return response()->json($result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    } 
    
    /**
    * matchMakingMatchConfig
    * @return View
    */
   public function matchMakingMatchConfig(MatchMaking $match, int $nummaps)
   {
       if(isset($match->game) && isset ($match->game->gamematchapihandler))
       {
            $gamematchapihandler = (new GameMatchApiHandler())->getGameMatchApiHandler($match->game->gamematchapihandler);
        
        
        foreach( $match->teams as $team)
        {
            $gamematchapihandler->addteam($team->name);

            foreach ($team->players as $player) {
                if (isset($player->user->steamid) && isset($player->user->steamname)) 
                {
                    $gamematchapihandler->addplayer($team->name, $player->user->steamid, $player->user->steamname, $player->user->id, $player->user->username);
                }
            }

        }
            if (isset($match->matchMakingServer->gameServer->gameserver_secret) && $match->game->matchmaking_autofinalize)
            {
                $finalizeurl = config('app.url')."/api/matchmaking/".$match->id."/finalize";
                $result = $gamematchapihandler->start($match->id,$nummaps, $match->team_size, $finalizeurl, $match->matchMakingServer->gameServer->gameserver_secret);
            }
            else
            {
                $result = $gamematchapihandler->start($match->id,$nummaps, $match->team_size, null, null);
            }
       }
       else
       {
           return "no gamematchapihandler for match available!";
       }
       

       return response()->json($result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
   }

}
