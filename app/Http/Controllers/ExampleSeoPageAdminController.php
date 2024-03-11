<?php

namespace App\Http\Controllers;

use App\Dto\Example\SeoPageFilterRequest;
use App\Dto\Example\SeoPageRequest as ExampleSeoPageRequest;
use App\Dto\SeoPageRequest;
use App\Http\Resources\ExampleSeoPageResource;
use App\Services\Example\SeoPageAdminService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

class ExampleSeoPageAdminController extends Controller
{
    public function __construct(protected SeoPageAdminService $service)
    {
        //
    }

    protected function getRequest(Request $request): ExampleSeoPageRequest
    {
        $data = $request->all();
        $filterRequest = new SeoPageFilterRequest(...(isset($data['seoPage']) ? $data['seoPage']['filters'] : []));
        $data['seoPage']['filters'] = $filterRequest;
        $seoRequest = new SeoPageRequest(...$data['seoPage']);
        $data['seoPage'] = $seoRequest;

        return new ExampleSeoPageRequest(...$data);
    }

    /**
     * @OA\Get (
     *     path="/api/seo-page/example/",
     *     summary="Getting list of seo pages",
     *     operationId="exampleSeoPageAdminList",
     *     tags={"Example/SeoPage"},
     *     security={
     *         {"bearer": {}},
     *     },
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="",
     *         example="1",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *       response=200,
     *       description="successful operation",
     *       @OA\JsonContent(
     *          @OA\Property(
     *              property="data",
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ExampleSeoPage")
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="Seo page not found"
     *     )
     * )
     * @param Request $request
     * @return AnonymousResourceCollection
     * @throws ValidationException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->validate($request, [
            'page' => 'nullable|numeric|min:1'
        ]);

        $page = $request->get('page', 1);
        $pageSize = 15;

        $paginator = $this->service->list($page, $pageSize);

        return ExampleSeoPageResource::collection($paginator);
    }

    /**
     * @OA\Get (
     *     path="/api/seo-page/example/{id}",
     *     summary="Showing seo page",
     *     operationId="exampleSeoPageAdminShow",
     *     tags={"Example/SeoPage"},
     *     security={
     *         {"bearer": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="",
     *         example="1",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *       response=200,
     *       description="successful operation",
     *       @OA\JsonContent(
     *          @OA\Property(
     *              property="data",
     *              type="object",
     *              ref="#/components/schemas/ExampleSeoPage"
     *          ),
     *          @OA\Property(
     *              property="dictionary",
     *              type="object",
     *              ref="#/components/schemas/ExampleSeoPageDistrict"
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="Seo page not found"
     *     )
     * )
     * @param int $id
     * @return ExampleSeoPageResource
     * @throws \App\Exceptions\SeoPageNotFoundException
     */
    public function show(int $id): ExampleSeoPageResource
    {
        $res = $this->service->show($id);

        return new ExampleSeoPageResource($res);
    }

    /**
     * @OA\Post (
     *     path="/api/seo-page/example",
     *     summary="Adding seo page",
     *     operationId="exampleSeoPageAdminStore",
     *     tags={"Example/SeoPage"},
     *     security={
     *         {"bearer": {}},
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ExampleSeoPage"
     *         )
     *     ),
     *     @OA\Response(
     *       response=201,
     *       description="successful operation",
     *       @OA\JsonContent(
     *          @OA\Property(
     *              property="data",
     *              type="object",
     *              ref="#/components/schemas/ExampleSeoPage"
     *          ),
     *          @OA\Property(
     *              property="dictionary",
     *              type="object",
     *              ref="#/components/schemas/ExampleSeoPageDistrict"
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="Seo page not found"
     *     )
     * )
     * @param Request $request
     * @return ExampleSeoPageResource
     * @throws ValidationException
     */
    public function store(Request $request): ExampleSeoPageResource
    {
        $dataRequest = $this->getRequest($request);
        $res = $this->service->store($dataRequest);

        return new ExampleSeoPageResource($res);
    }

    /**
     * @OA\Put (
     *     path="/api/seo-page/example/{id}",
     *     summary="Updating seo page",
     *     operationId="exampleSeoPageAdminUpdate",
     *     tags={"Example/SeoPage"},
     *     security={
     *         {"bearer": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="",
     *         example="1",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ExampleSeoPage"
     *         ),
     *     ),
     *     @OA\Response(
     *       response=200,
     *       description="successful operation",
     *       @OA\JsonContent(
     *          @OA\Property(
     *              property="data",
     *              type="object",
     *              ref="#/components/schemas/ExampleSeoPage"
     *          ),
     *          @OA\Property(
     *              property="dictionary",
     *              type="object",
     *              ref="#/components/schemas/ExampleSeoPageDistrict"
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="Seo page not found"
     *     )
     * )
     * @param int $id
     * @param Request $request
     * @return ExampleSeoPageResource
     * @throws ValidationException
     * @throws \App\Exceptions\SeoPageNotFoundException
     */
    public function update(int $id, Request $request): ExampleSeoPageResource
    {
        $dataRequest = $this->getRequest($request);
        $res = $this->service->update($id, $dataRequest);

        return new ExampleSeoPageResource($res);
    }

    /**
     * @OA\Delete (
     *     path="/api/seo-page/example/{id}",
     *     summary="Removing seo page",
     *     operationId="exampleSeoPageAdminDelete",
     *     tags={"Example/SeoPage"},
     *     security={
     *         {"bearer": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="",
     *         example="1",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok"
     *     )
     * )
     *
     * @param int $id
     * @return void
     * @throws \App\Exceptions\SeoPageNotFoundException
     */
    public function destroy(int $id): void
    {
        $this->service->destroy($id);
    }

    /**
     *  @OA\Get  (
     *     path="/api/seo-page/example/create",
     *     summary="Default values for creating seo page",
     *     operationId="exampleSeoPageAdminCreate",
     *     tags={"Example/SeoPage"},
     *     security={
     *         {"bearer": {}},
     *     },
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/ExampleSeoPage"
     *             )
     *         )
     *     )
     * )
     * @return ExampleSeoPageResource
     */
    public function create(): ExampleSeoPageResource
    {
        $data = $this->service->create();

        return new ExampleSeoPageResource($data);
    }
}
