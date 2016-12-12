<?php

namespace IugoGameLib\Leaderboard;

interface ImmutableScoreDAO { 
    public function getWith($userId, $leaderboardId);
    public function getAll();
}