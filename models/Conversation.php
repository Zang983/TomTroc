<?php

class Conversation
{
    function __construct(private int $idUser1, private int $idUser2, private string $contentLastMessage, private string $timestampLastMessage ,private int $id = -1)
    {
    }

}