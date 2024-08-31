<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $questionsData = [
            ['1 + 1 =', [1]],
            ['2 + 2 =', [0, 1]],
            ['3 + 3 =', [0, 2, 3]],
            ['4 + 4 =', [0, 3]],
            ['5 + 5 =', [2]],
            ['6 + 6 =', [3, 4]],
            ['7 + 7 =', [1]],
            ['8 + 8 =', [0]],
            ['9 + 9 =', [0, 2, 3]],
            ['10 + 10 =', [3]]
        ];

        $questions = [];
        foreach ($questionsData as $data) {
            $question = new Question();
            $question->setText($data[0]);
            $question->setCorrectAnswers($data[1]);

            $manager->persist($question);
            $questions[] = $question;
        }

        $answersData = [
            [1, '3'],
            [1, '2'],
            [1, '0'],

            [2, '4'],
            [2, '3 + 1'],
            [2, '10'],

            [3, '1 + 5'],
            [3, '1'],
            [3, '6'],
            [3, '2 + 4'],

            [4, '8'],
            [4, '4'],
            [4, '0'],
            [4, '0 + 8'],

            [5, '6'],
            [5, '18'],
            [5, '10'],
            [5, '9'],
            [5, '0'],

            [6, '3'],
            [6, '9'],
            [6, '0'],
            [6, '12'],
            [6, '5 + 7'],

            [7, '5'],
            [7, '14'],

            [8, '16'],
            [8, '12'],
            [8, '9'],
            [8, '5'],

            [9, '18'],
            [9, '9'],
            [9, '17 + 1'],
            [9, '2 + 16'],

            [10, '0'],
            [10, '2'],
            [10, '8'],
            [10, '20']
        ];

        foreach ($answersData as $data) {
            $answer = new Answer();
            $answer->setQuestion($questions[$data[0] - 1]);
            $answer->setText($data[1]);

            $manager->persist($answer);
        }

        $manager->flush();
    }
}
