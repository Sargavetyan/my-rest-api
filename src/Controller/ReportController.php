<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Service\JsonService;
use App\Service\XmlService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route(
     *     name="report_xml",
     *     path="/report/xml",
     *     methods={"GET"},
     *     defaults={"_api_item_operation_name"="report_xml"}
     * )
     */
    public function xmlReport(XmlService $xmlService): Response
    {
        /** @var TeamRepository $teamRepository */
        $teamRepository = $this->entityManager->getRepository(Team::class);

        $teams = $teamRepository->findAll();

        $response = new Response($xmlService->responseFormatting($this->responseFormat($teams))->asXML());
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    /**
     * @Route(
     *     name="report_json",
     *     path="/report/json",
     *     methods={"GET"},
     *     defaults={"_api_item_operation_name"="report_json"}
     * )
     */
    public function jsonReport(JsonService $jsonService): JsonResponse
    {
        /** @var TeamRepository $teamRepository */
        $teamRepository = $this->entityManager->getRepository(Team::class);

        $teams = $teamRepository->findAll();

        return $jsonService->responseFormatting($this->responseFormat($teams));
    }

    /**
     * @param Team[] $teams
     * @return array<int, mixed>
     */
    private function responseFormat(array $teams): array
    {
        $teamsResponseTemp = [];

        foreach ($teams as $team) {
            $teamAccounts = $team->getAccounts();
            $teamsAccountsResponseTemp = [];

            foreach ($teamAccounts as $teamAccount) {
                $teamsAccountsResponseTemp[] = [
                    'id' => $teamAccount->getId(),
                    'name' => $teamAccount->getName(),
                ];
            }

            $teamsResponseTemp[] = [
                'name' => $team->getName(),
                'size' => count($teamAccounts),
                'accounts' => $teamsAccountsResponseTemp,
            ];
        }

        return $teamsResponseTemp;
    }
}
