<?php
    class Class1
    {
        function printMessage($typeClass): void{
            echo "Вызвался $typeClass" . PHP_EOL;
        }

        static function main_writeJSON($fileJSON, $login, $Date, $message): void
        {
            $userMessages = json_decode(file_get_contents($fileJSON), true);
            $userMessages['messages'][] = ['user' => $login, 'date' => $Date, 'message' => $message];
            file_put_contents($fileJSON, json_encode($userMessages));
        }

        static function users_writeJSON($fileJSON, $login, $password): void
        {
            $usersArray = json_decode(file_get_contents($fileJSON), true);
            $usersArray['users'][] = ['login' => $login, 'password' => $password];
            file_put_contents($fileJSON, json_encode($usersArray));
        }
    }