<?php

namespace IugoGameLib\Document;

interface DocumentDecoder {
    //source is string
    //return document model node
    function decode($source);
}
