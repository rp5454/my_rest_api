<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/process", methods={"POST"})
     */
    public function processData(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Check if 'data' key is present and is an array
        if (!isset($data['data']) || !is_array($data['data'])) {
            return new JsonResponse(['is_success' => false, 'message' => 'Invalid input'], 400);
        }

        $numbers = [];
        $alphabets = [];

        foreach ($data['data'] as $item) {
            if (ctype_alpha($item)) {
                $alphabets[] = strtoupper($item);
            } elseif (ctype_digit($item)) {
                $numbers[] = $item; // Keeping numbers as strings
            }
        }

        // Determine the highest alphabet
        $highestAlphabet = '';
        foreach ($alphabets as $alphabet) {
            if ($alphabet > $highestAlphabet) {
                $highestAlphabet = $alphabet;
            }
        }

        // Prepare the response
        $response = [
            'is_success' => true,
            'user_id' => 'john_doe_17091999',
            'email' => 'john@xyz.com',
            'roll_number' => 'ABCD123',
            'numbers' => $numbers,
            'alphabets' => $alphabets,
            'highest_alphabet' => [$highestAlphabet] // Wrap in array
        ];

        return new JsonResponse($response);
    }
}
