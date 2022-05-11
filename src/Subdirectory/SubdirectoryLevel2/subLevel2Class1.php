<?php
    namespace Subdirectory\SubdirectoryLevel2;
    use Class1;

    class subLevel2Class1
    {
        function printMessage($typeClass): void
        {
            echo "Вызвался $typeClass" . PHP_EOL;
        }

        static function checkUser($fileJSON, $login, $password) : bool
        {
            $jsonObject = json_decode(file_get_contents($fileJSON), false);

            foreach ($jsonObject->users as $user)
            {
                if ($login === $user->login && $password !== $user->password)
                {
                    echo "<script> alert(\"Неверный пароль\") </script>";
                    return false;
                }
                elseif ($login === $user->login && $password === $user->password)
                    return true;
            }
            Class1::users_writeJSON($fileJSON, $login, $password);
            return true;
        }
    }