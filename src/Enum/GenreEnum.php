<?php

namespace App\Enum;

enum GenreEnum :string
{
    case Novel = 'Novel';
    case Crime = 'Crime Thriller';
    case Fiction = 'Fiction';
    case Non_Fiction = 'Non_Fiction';
    case Horror = 'Horror';
    case Manga = 'Manga';
    case Philosophy= 'Philosophy';
    case Self_Help = 'Self_Help';
}
