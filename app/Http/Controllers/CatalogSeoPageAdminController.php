<?php

namespace App\Http\Controllers;

//use Anflat\GRPC\Auth\Permissions\RuleType;
//use Anflat\Microservice\Contracts\GrpcClient\AuthClientContract;
//use Anflat\Microservice\Tools\CheckRuleHelper;
use App\Exceptions\PermissionDeniedException;
use App\Dto\Catalog\SeoPageFilterAddressRequest;
use App\Dto\Catalog\SeoPageFilterRequest;
use App\Dto\Catalog\SeoPageRequest as CatalogSeoPageRequest;
use App\Dto\SeoPageRequest;
use App\Http\Resources\CatalogSeoPageResource;
use App\Services\Catalog\SeoPageAdminService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class CatalogSeoPageAdminController extends Controller
{
    public function __construct(protected AuthClientContract $authClient, protected SeoPageAdminService $service)
    {
        $this->checkRule();
    }

    /**
     * @return void
     * @throws PermissionDeniedException
     * @throws \Anflat\Microservice\Exceptions\InvalidRuleTypeException
     */
    protected function checkRule()
    {
        $ruleType = RuleType::SITE_CATALOG_SEO_PAGE;
        $rules = $this->authClient->checkRule([$ruleType]);
        if (!CheckRuleHelper::checkRule($ruleType, $rules)) {
            throw new PermissionDeniedException();
        }
    }

    protected function getRequest(Request $request): CatalogSeoPageRequest
    {
        $data = $request->all();
        if (isset($data['seoPage']) && isset($data['seoPage']['filters']) && isset($data['seoPage']['filters']['address'])) {
            $arr = [];
            foreach ($data['seoPage']['filters']['address'] as $address) {
                $arr[] = new SeoPageFilterAddressRequest(...$address);
            }

            $data['seoPage']['filters']['address'] = $arr;
        }

        $filterRequest = new SeoPageFilterRequest(...($data['seoPage'] ? $data['seoPage']['filters'] : []));
        $data['seoPage']['filters'] = $filterRequest;
        $seoRequest = new SeoPageRequest(...$data['seoPage']);
        $data['seoPage'] = $seoRequest;

        return new CatalogSeoPageRequest(...$data);
    }

    /**
     * @OA\Get (
     *     path="/api/v1/seo-page/catalog/",
     *     summary="Сео страницы каталога",
     *     operationId="siteCatalogSeoPageAdminList",
     *     tags={"Site/Catalog/SeoPage"},
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
     *              @OA\Items(ref="#/components/schemas/SiteCatalogSeoPage")
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
        $pageSize = config('pagination.per_page');

        $PageList = $this->service->list($page, $pageSize);
        $paginator = new LengthAwarePaginator($PageList->getData(), $PageList->getPageCount(), $pageSize, $page);

        return CatalogSeoPageResource::collection($paginator);
    }

    /**
     * @OA\Get (
     *     path="/api/v1/site/catalog/seo-page/{id}",
     *     summary="Сео страница каталога",
     *     operationId="siteCatalogSeoPageAdminShow",
     *     tags={"Site/Catalog/SeoPage"},
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
     *              ref="#/components/schemas/SiteCatalogSeoPage"
     *          ),
     *          @OA\Property(
     *              property="dictionary",
     *              type="object",
     *              ref="#/components/schemas/SiteCatalogSeoPageDistrict"
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="Seo page not found"
     *     )
     * )
     * @param int $id
     * @return CatalogSeoPageResource
     * @throws \App\Exceptions\SeoPageNotFoundException
     */
    public function show(int $id): CatalogSeoPageResource
    {
        $res = $this->service->show($id);

        return new CatalogSeoPageResource($res);
    }

    /**
     * @OA\Post (
     *     path="/api/v1/site/catalog/seo-page",
     *     summary="Добавление Сео страницы каталога",
     *     operationId="siteCatalogSeoPageAdminStore",
     *     tags={"Site/Catalog/SeoPage"},
     *     security={
     *         {"bearer": {}},
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/SiteCatalogSeoPage"
     *         )
     *     ),
     *     @OA\Response(
     *       response=201,
     *       description="successful operation",
     *       @OA\JsonContent(
     *          @OA\Property(
     *              property="data",
     *              type="object",
     *              ref="#/components/schemas/SiteCatalogSeoPage"
     *          ),
     *          @OA\Property(
     *              property="dictionary",
     *              type="object",
     *              ref="#/components/schemas/SiteCatalogSeoPageDistrict"
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="Seo page not found"
     *     )
     * )
     * @param Request $request
     * @return CatalogSeoPageResource
     * @throws ValidationException
     */
    public function store(Request $request): CatalogSeoPageResource
    {
        $dataRequest = $this->getRequest($request);
        $res = $this->service->store($dataRequest);

        return new CatalogSeoPageResource($res);
    }

    /**
     * @OA\Put (
     *     path="/api/v1/site/catalog/seo-page/{id}",
     *     summary="Обновление Сео страницы списков каталога",
     *     operationId="siteCatalogSeoPageAdminUpdate",
     *     tags={"Site/Catalog/SeoPage"},
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
     *             ref="#/components/schemas/SiteCatalogSeoPage"
     *         ),
     *     ),
     *     @OA\Response(
     *       response=200,
     *       description="successful operation",
     *       @OA\JsonContent(
     *          @OA\Property(
     *              property="data",
     *              type="object",
     *              ref="#/components/schemas/SiteCatalogSeoPage"
     *          ),
     *          @OA\Property(
     *              property="dictionary",
     *              type="object",
     *              ref="#/components/schemas/SiteCatalogSeoPageDistrict"
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
     * @return CatalogSeoPageResource
     * @throws ValidationException
     * @throws \App\Exceptions\SeoPageNotFoundException
     */
    public function update(int $id, Request $request): CatalogSeoPageResource
    {
        $dataRequest = $this->getRequest($request);
        $res = $this->service->update($id, $dataRequest);

        return new CatalogSeoPageResource($res);
    }

    /**
     * @OA\Delete (
     *     path="/api/v1/site/catalog/seo-page/{id}",
     *     summary="Удаление Сео страницы каталога",
     *     operationId="siteCatalogSeoPageAdminDelete",
     *     tags={"Site/Catalog/SeoPage"},
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
     *     path="/api/v1/site/catalog/seo-page/create",
     *     summary="Дефолтные значения Сео страницы каталога",
     *     operationId="siteCatalogSeoPageAdminCreate",
     *     tags={"Site/Catalog/SeoPage"},
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
     *                 ref="#/components/schemas/SiteCatalogSeoPage"
     *             ),
     *             @OA\Property(
     *                 property="dictionary",
     *                 type="object",
     *                 ref="#/components/schemas/SiteCatalogSeoPageDistrict"
     *             ),
     *         )
     *     )
     * )
     * @return CatalogSeoPageResource
     */
    public function create(): CatalogSeoPageResource
    {
        $data = $this->service->create();

        return new CatalogSeoPageResource($data);
    }
}
