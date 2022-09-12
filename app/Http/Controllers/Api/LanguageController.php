<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Repositories\LanguageRepository;

class LanguageController extends AppBaseController
{
    public function __construct(LanguageRepository $languageRepository){
        $this->languageRepository = $languageRepository;
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Languages"},
     *     path="/languages",
     *     description="Get Languages",
     *     summary="Get Languages",
     *     operationId="getLanguages",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Succuess response"
     *     ,@OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="401",
     *     description="Not Authorized Invalid or missing Authorization header"
     *     ,@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *  ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function index(){
        $languages = $this->languageRepository->all();
        if (is_null($languages)) {
            return $this->sendError('Language not available');
        }
        return $this->sendResponse(
            $languages, 'Language get Successfully.'
        );
    }
}
