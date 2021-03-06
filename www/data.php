<?php

function send_msg($message) {

    $answer = "";
    $fp = fsockopen("localhost", 44777, $errno, $errstr, 30);
    if (!$fp) {
        return '{"error":"true", "before":"true"}';
    }

    fwrite($fp, "PHP:" . $message . ":[end]");
    while (!feof($fp)) {
        $answer .= fgets($fp, 128);
    }
    fclose($fp);
    return $answer;
}

switch($_GET["data"]) {
    case "UPDATE_NICK":
        echo send_msg("NEW_NICK:" . $_GET["nickname"]);
        break;
    case "UPDATE_DATA":
        echo send_msg("UPDATE");
        break;
    case "GET_FS":
        echo send_msg("GET_FS");
        break;
    case "GET_PEERS":
        echo send_msg("GET_PEERS");
        break;
    case "CREATE_FOLDER":
        echo send_msg("CREATE_FOLDER:" . $_GET["fullpath"]);
        break;
    case "UPDATE_FOLDER":
        echo send_msg("UPDATE_FOLDER:" . $_GET["fullpath"] . ":" . $_GET["newname"]);
        break;
    case "UPDATE_FILE":
        echo send_msg("UPDATE_FILE:" . $_GET["fullpath"] . ":" . $_GET["newname"]);
        break;
    case "DOWNLOAD_FILE":
        echo send_msg("DOWNLOAD_FILE:" . $_GET["fullpath"]);
        break;
    case "DELETE_FOLDER":
        echo send_msg("DELETE_FOLDER:" . $_GET["fullpath"]);
        break;
    case "DELETE_FILE":
        echo send_msg("DELETE_FILE:" . $_GET["fullpath"]);
        break;
    case "CREATE_FILE":
        send_msg("CREATE_FILE:" . $_GET["fullpath"] . ":" . $_GET["file"]);
        close();
        break;
}

function close() {
    echo  "<script type='text/javascript'>";
    echo "window.close();";
    echo "</script>";
}


?>