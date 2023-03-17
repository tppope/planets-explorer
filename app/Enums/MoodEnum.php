<?php

namespace App\Enums;

enum MoodEnum: string
{
    case DISGUST = 'disgust';
    case SURPRISE = 'surprise';
    case ANGER = 'anger';
    case FEAR = 'fear';
    case HAPPINESS = 'happiness';
    case SADNESS = 'sadness';
    case NEUTRAL = 'neutral';
}
