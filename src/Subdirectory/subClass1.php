<?php
    namespace Subdirectory;
    class subClass1
    {
        function printMessage($typeClass): void {
            echo "Вызвался $typeClass" . PHP_EOL;
        }

        function printMessages($fileJSON): void
        {
            $jsonObject = json_decode(file_get_contents($fileJSON), false);

            foreach ($jsonObject->messages as $user)
            {
                $Login_Date = $user->user . ' ' . $user->date;
                echo "<div style='text-align: center'>$Login_Date</div>";
                echo "$user->message<br/><br/>";
            }
        }
    }