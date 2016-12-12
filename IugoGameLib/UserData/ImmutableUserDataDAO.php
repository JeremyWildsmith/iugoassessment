<?php

namespace IugoGameLib\UserData;

interface ImmutableUserDataDAO {
    public function getWith($userId);
}
