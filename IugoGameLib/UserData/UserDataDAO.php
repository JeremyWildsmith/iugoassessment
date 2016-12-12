<?php

namespace IugoGameLib\UserData;

interface UserDataDAO extends ImmutableUserDataDAO {
    public function update($userData);
    public function save();
}
