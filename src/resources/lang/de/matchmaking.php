<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Matchmaking Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'ended' => 'beendet',
    'live' => 'live',
    'pending' => 'wartend',
    'waitforplayers' => 'auf Spieler warten',
    'draft' => 'Entwurf',
    'match' => 'Match',
    'matchmaking' => 'Matchmaking',
    'matchowner' => 'Matcheigentümer',
    'notsignedup' => 'nicht angemeldet',
    'ownedmatches' => 'meine Matches',
    'ownedteams' => 'Matches mit Teams deren Mitglied ich bin',
    'publicmatches' => 'Öffentliche Matches',
    'signedup' => 'angemeldet',
    'signupsclosed' => 'anmeldung geschlossen',
    'teamcount' => 'Teamanzahl:',
    'teamowner' => 'Teameigentümer',
    'teamsizes' => 'Teamgröße:',
    'game' => 'Spiel:',
    'add' => 'Hinzufügen',
    'addteam' => 'Team Hinzufügen',
    'currentstatus' => 'Aktueller Status:',
    'deletematch' => 'Match löschen',
    'deleteteam' => 'Team löschen',
    'doyouwanttojointeam' => 'Willst du folgendem Team beitreten? :',
    'editteam' => 'Team bearbeiten',
    'finalizematch' => 'Match finalisieren',
    'inviteurl' => 'Einladelink',
    'jointeam' => 'Team beitreten',
    'matchinviteurl' => 'Match Einladelink',
    'name' => 'Name',
    'openmatch' => 'Match Öffnen',
    'removefrommatch' => 'von Match entfernen',
    'leavematch' => 'Match verlassen',
    'score' => 'Punktzahl',
    'startmatch' => 'Match starten',
    'submit' => 'Bestätigen',
    'team' => 'Team',
    'user' => 'Benutzer',
    'editmatch' => 'Match bearbeiten',
    'firstteamname' => 'Team 1 Name',
    'teamsize' => 'Team Größe',
    'teamcounts' => 'Anzahl der Teams',
    'teamname' => 'Team Name',
    'games' => 'Spiel',
    'scoreof' =>'Punktezahl von',
    'thisisyourteam' => 'Das ist dein Team!',
    'nopermissions' => 'Du hast keine Berechtigungen dieses Match anzuzeigen! Du benötigst entweder einen Einladungslink des Matcheigentümers oder eines Teameigentümers oder das Match muss vom Eigentümer als öffentlich markiert werden!',
    'matchmakinghome' => 'Klicke hier um andere Matches finden.',
    'maxopened' => 'Du hast schon mehr matches gleichzeitig offen als erlaubt! Finalisiere erst alte matches!',
    'error' => 'Fehler',
    'team_size_required'    => 'Teamgröße darf nicht leer sein',
    'team_size_mustbeoneof'    => 'Teamgröße muss eine der folgenden sein: 1v1,2v2,3v3,4v4,5v5,6v6',
    'team_count_required'    => 'Teamanzahl darf nicht leer sein',
    'team_count_integer'    => 'Teamanzahl muss eine zahl sein',
    'teamname_required'    => 'Teamname darf nicht leer sein',
    'teamcount_smallerthangamesmin' => 'Teamanzahl ist kleiner als die minimale Teamanzahl des ausgewählten Spiels! Minimum ist ',
    'teamcount_biggerthangamesmax' => 'Teamanzahl ist größer als die maximale Teamanzahl des ausgewählten Spiels! Maximum ist ',
    'cannotcreatematch' => 'Match kann nicht angelegt werden!',
    'cannotcreatteambutcannotdeletematch' => 'Team 1 kann nicht angelegt werden, Match kann aber nicht gelöscht werden! Datenbank korrupt!',
    'cannotcreateteam1' => 'Team1 konnte nicht angelegt werden, Match wurde nicht erstellt!',
    'cannotcreateteamplayer1butcannotdeleteteam' => 'Teamplayer 1 konnte nicht erstellt werden, Team kann aber nicht gelöscht werden! Datenbank korrupt!',
    'cannotcreateteamplayer1butcannotdeletematch' => 'Teamplayer 1 konnte nicht erstellt werden, Match kann aber nicht gelöscht werden! Datenbank korrupt!',
    'cannotcreateteamplayer1' => 'Team1 konnte nicht angelegt werden, Match und Team wurden nicht erstellt!',
    'successfullycreatedmatch' => 'Match erfolgreich angelegt!',
    'cannotupdatematchnotowner' => 'Konnte Match nicht aktualisieren, da du nicht der Eigentümer bist!',
    'cannotupdatematchstatus' => 'Du kannst das Match nicht aktualisieren während es live oder completed ist!',
    'tomanyplayersforteamsize' => 'In mindestens einem Team befinden sich zu viele Spieler um die Teamgröße zu setzen!',
    'cannotupdatematch' => 'Match konnte nicht aktualisiert werden',
    'successfullyupdatedmatch' => 'Match wurde erfolgreich aktualisiert',
    'cannotaddteamstatus' => 'Du kannst kein Team hinzufügen während das Match live oder completed ist!',
    'cannotaddteamcount' => 'Es können wegen der eingestellten Teamanzahl keine weiteren Teams angelegt werden!',
    'youalreadyareinateam' => 'Du kannst kein Team hinzufügen, da du bereits Mitglied eines Teams bist!',
    'cannotcreateteam' => 'Team konnte nicht angelegt werden!',
    'cannotcreateteamplayerforowner' => 'Konte Teamplayer für Teamowner nicht erstellen!',
    'successfullyaddedteam' => 'Team erfolgreich hinzugefügt',
    'cannotupdateteamnotowner' => 'Du kannst das Team nicht aktualisieren, da du nicht der Eigentümer bist!',
    'cannotupdateteamstatus' => 'Du kannst kein Team bearbeiten während das Match live oder completed ist!',
    'cannotsaveteam' => 'Team konnte nicht gepseichert werden!',
    'successfullyupdatedteam' => 'Team wurde erfolgreich aktualisiert!',
    'cannotdeleteteamstatus' => 'Du kannst kein Team bearbeiten während das Match live oder completed ist!',
    'cannotdeleteinitialteam' => 'Das initiale Team kann nicht gelöscht werden!',
    'cannotdeleteteamplayers' => 'Konnte Teamplayer nicht löschen!',
    'cannotdeleteteam' => 'Konnte Team nicht löschen!',
    'deletedteam' => 'Team wurde gelöscht!',
    'cannnotjoinstatus'=> 'Du kannst dem Team nicht beitreten während das Match live oder completed ist!',
    'cannotjoinalreadyfull' => 'Das Team ist bereits voll!',
    'cannotcreateteamplayer' => 'Teamplayer konnte nicht erstellt werden!',
    'successfiullyaddedteamplayer' => 'Du bist dem Team erfolgreich beigetreten!',
    'cannotleavestatus' => 'Du kannst das Team nicht verlassen während das Match live oder completed ist!',
    'cannotdeleteteamplayer' => 'Teamplayer konnte nicht gelöscht werden!',
    'successfullydeletedteamplayer' => 'Teamplayer wurde erfolgreich gelöscht!',
    'cannotdeletematchnotowner' => 'Du kannst das Match nicht löschen da du nicht der Eigentümer bist!',
    'cannotdeleteplayers' => 'Teamplayer konnten nicht gelöscht werden!',
    'cannotdeleteteams' => 'Teams konnten nicht gelöscht werden!',
    'cannotdeletematch' => 'Match konnte nicht gelöscht werden!',
    'successfullydeletedmatch' => 'Das Match wurde erfolgreich gelöscht!',
    'cannotstartmatchnotowner' => 'Du kannst das Match nicht starten da du nicht der Eigentümer bist!',
    'matchalreadystartedorcompleted' => 'Das Match ist bereits live oder completed',
    'notallrequiredteamsarethere' => 'Nicht alle notwendigen Teams sind im Match vorhanden!',
    'notenoughplayerstostart' => 'Mindestens ein Team hat nicht genug Spieler für die eingestellte Teamgröße!',
    'cannotstartmatch' => 'Match konnte nicht gestartet werden!',
    'matchstarted' => 'Match wurde gestartet!',
    'matchpending' => 'Match start wurde angefordert, es muss von einem Administrator freigeschalten werden!',
    'cannotopenmatchnotowner' => 'Du kannst das Match nicht öffnen da du nicht der Eigentümer bist!',
    'matchalreadyopenliveorcompleted' => 'Das Match ist bereits open / live oder completed',
    'cannotopenmatch' => 'Match konnte nicht geöffnet werden!',
    'matchopened' => 'Match wurde erfolgreich geöffnet',
    'cannotfinalizenotowner' => 'Du kannst das Match nicht finalisieren da du nicht der Eigentümer bist!',
    'missingscoreforteam' => 'Für mindestens ein Team wurde keine Punktzahl angegeben!',
    'scorecouldnotbesetted' => 'Für mindestens ein Team konnte die Punktzahl nicht gespeichert werden!',
    'cannotfinalize' => 'Match konnte nicht finalisiert werden! Es ist somit immer noch aktiv!',
    'matchfinalized' => 'Match wurde erfolgreich finalisiert!',
    'invitationnotfound' => 'Einladungslink konnte nicht gefunden werden!',
    'pleaselogin' => 'Bitte einloggen um das Matchmaking zu benutzen',
    'cannotjoinyoualreadyareinateam' => 'Du kannst dem Team nicht beitreten, da du bereits Mitglied eines Teams bist!',

   
];
