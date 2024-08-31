<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Test;
use App\Entity\TestResult;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test/start", name="start_test", methods={"GET"})
     */
    public function startTest(EntityManagerInterface $em): Response
    {
        $questions = $em->getRepository(Question::class)->findAll();
        shuffle($questions);

        return $this->render('test/start.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/test/submit", name="submit_test", methods={"POST"})
     */
    public function submitTest(Request $request, EntityManagerInterface $em): Response
    {
        $submittedAnswers = $request->request->all('answers');
        $test = new Test();
        $test->setTimestamp(new \DateTime());

        $correctQuestions = [];
        $incorrectQuestions = [];

        $questionsData = $em->getRepository(Question::class)->findBy([
            'id' => array_keys($submittedAnswers)
        ]);

        $questions = [];
        foreach ($questionsData as $question) {
            $questions[$question->getId()] = $question;
        }

        foreach ($submittedAnswers as $questionId => $answers) {
            if (empty($answers)) {
                continue;
            }

            $question = $questions[$questionId];

            if ($question) {
                $isCorrect = !count(array_diff($answers, $question->getCorrectAnswers()));

                $testResult = new TestResult();
                $testResult->setQuestion($question);
                $testResult->setCorrect($isCorrect);
                $testResult->setTimestamp(new \DateTime());
                $testResult->setTest($test);

                $em->persist($testResult);
                $test->addResult($testResult);

                if ($isCorrect) {
                    $correctQuestions[] = $question;
                } else {
                    $incorrectQuestions[] = $question;
                }
            }
        }

        if (count($test->getResults()) > 0) {
            $em->persist($test);
            $em->flush();
        }

        if (!count($test->getResults())) {
            return $this->render('test/result.html.twig', [
                'message' => 'Вы не ответили ни на один вопрос.',
            ]);
        }

        return $this->render('test/result.html.twig', [
            'correctQuestions' => $correctQuestions,
            'incorrectQuestions' => $incorrectQuestions,
        ]);
    }
}
