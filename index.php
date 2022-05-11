<?php
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    use Twig\Loader\FilesystemLoader;
    use Twig\Environment;

    use Class1 as JSON;
    use Subdirectory\subClass1;
    use Subdirectory\SubdirectoryLevel2\subLevel2Class1 as User;

    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $main_fileJSON = "userMessages.json";
    $users_fileJSON = "users.json";
    $message = $_POST['message'];
    $Date = date("H:i:s");
    $login = $_POST['login'];
    $password = $_POST['password'];
    $User = new subClass1();

    $logger = new Logger('INFO LOGGER');
    $logger->pushHandler(new StreamHandler(__DIR__ . '/logs/debug/log', Logger::INFO));

    $loader = new FilesystemLoader(__DIR__ . '/template');
    $twig = new Environment($loader);

    if (isset($_POST['resetButton']))
    {
        $jsonObject = json_decode(file_get_contents($main_fileJSON), false);
        foreach ($jsonObject->messages as $user)
        {
            unset($jsonObject->messages);
        }
        file_put_contents($main_fileJSON, json_encode($jsonObject));
        unset($jsonObject);

        echo "<script> document.getElementById('Message_Block').innerHTML = \"\"; </script>";
    }

    try {
        if (isset($_POST['button'])) {
            if ($login === '' || $password === '') {
                echo "<script>alert(\"Для авторизации введите логин и пароль!\")</script>";
            } else if ($message === '')
                echo "<script>alert(\"Поле для сообщения не должно быть пустым!\")</script>";
            else if (User::checkUser($users_fileJSON, $login, $password))
            {
                $logger->info('Caught user: ', array('user' => $login, 'message' => $message, 'time' => $Date));
                JSON::main_writeJSON($main_fileJSON, $login, $Date, $message);

                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }

        echo $twig->render('form.twig');
        echo $twig->render('index.twig', [
            'user' => $User,
            'main_fileJSON' => $main_fileJSON,
        ]);

    } catch (Exception $exception) {
        die ('ERROR: ' . $exception->getMessage());
    }
