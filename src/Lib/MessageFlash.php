<?php

namespace App\PlayToWin\Lib;

use App\PlayToWin\Modele\HTTP\Session;

class MessageFlash
{
    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    //["sucess" => ["msg1","msg2"], "info" => ["msg3","msg4"]]
    public static function ajouter(string $type, string $message): void {
        $session = Session::getInstance();

        $msgType = $session->lire(self::$cleFlash)??[];

        if (!isset($msgType[$type])) {
            $msgType[$type] = [];
        }
        $msgType[$type][] = $message;

        $session->enregistrer(self::$cleFlash, $msgType);
    }

    public static function contientMessage(string $type): bool {
        $session = Session::getInstance();
        $msgType = $session->lire(self::$cleFlash);
        return isset($msgType[$type]);
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array{
        $session = Session::getInstance();
        $msgType = $session->lire(self::$cleFlash)??[];
        $rep[$type] = $msgType[$type];
        unset($msgType[$type]);
        $session->enregistrer(self::$cleFlash, $msgType);
        return $rep;

    }

    public static function lireTousMessages(): array{
        $session = Session::getInstance();
        $messages = $session->lire(self::$cleFlash)?? [];
        $session->supprimer(self::$cleFlash);
        return $messages;
    }
}
