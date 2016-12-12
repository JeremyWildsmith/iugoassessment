<?php

namespace IugoGameLib\Leaderboard;

use IugoGameLib\Leaderboard\ImmutableScoreDAO;

interface ScoreDAO extends ImmutableScoreDAO {
    public function update($score);
    public function delete($score);
    public function save();
}