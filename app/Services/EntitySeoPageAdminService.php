<?php

namespace App\Services;

//use Anflat\DoctrineLaravelPagination\PaginationHelper;
use App\Contracts\EntitySeoPageRepository;
use App\Contracts\SeoPageGroupRepository;
use App\Contracts\SeoPageRepository;
use App\Contracts\EntitySeoPageAdminServiceContract;
use App\Dto\EntitySeoPageList;
use App\Dto\EntitySeoPageRequest;
use App\Entity\EntitySeoPage;
use App\Entity\SeoPage;
use App\Entity\SeoPageGroup;
use App\Exceptions\SeoPageNotFoundException;
use DateTimeImmutable;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use LaravelDoctrine\ORM\Facades\EntityManager;

abstract class EntitySeoPageAdminService implements EntitySeoPageAdminServiceContract
{
    protected EntitySeoPageRepository|EntityRepository $repository;

    protected SeoPageRepository|EntityRepository $seoPageRepo;

    protected string $alias;

    public function __construct()
    {
        $this->seoPageRepo = app(SeoPageRepository::class);
    }

    protected function getCacheId(int $id): string
    {
        return $this->alias . '_' . $id;
    }

    public function resetCache(int $id): void
    {
        Cache::forget($this->getCacheId($id));
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return EntitySeoPageList
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function list(int $page, int $pageSize): EntitySeoPageList
    {
        $EntitySeoPageList = new EntitySeoPageList();

        $query = $this->repository->createQueryBuilder($this->alias);
        $query->select($this->alias)
            ->leftJoin("$this->alias.seoPage", "seoPage");

        $query->orderBy("seoPage.sort");

        $dataPagination = PaginationHelper::paginationData($query, $pageSize, $page); // TODO Here is private package from previous job.

        $EntitySeoPageList->setPageCount($dataPagination->getTotalRows());

        foreach ($dataPagination->items as $item) {
            $EntitySeoPageList->addData($item);
        }

        return $EntitySeoPageList;
    }

    /**
     * @param int $id
     * @return EntitySeoPage
     * @throws SeoPageNotFoundException
     */
    public function show(int $id): EntitySeoPage
    {
        $date = new DateTimeImmutable();
        $expireAt = $date->modify('+3 day');

        return Cache::remember($this->getCacheId($id), $expireAt, function () use ($id) {
            $entity = $this->repository->find($id);
            /** @var EntitySeoPage|null $entity */

            if (!$entity) {
                throw new SeoPageNotFoundException();
            }

            return $entity;
        });
    }

    public function create(): EntitySeoPage
    {
        return $this->repository->new();
    }

    /**
     * @throws ValidationException
     */
    protected function validate(EntitySeoPageRequest $request, ?int $id = null)
    {
        Validator::make($request->toArray(), [
            'seoPage' => ['required', 'array'],
        ])->validate();

        ValidateSeoPageService::validate($request->getSeoPage(), $request->getSeoPage()->getId());
    }

    /**
     * @param EntitySeoPageRequest $data
     * @return EntitySeoPage
     * @throws ValidationException
     */
    public function store(EntitySeoPageRequest $data): EntitySeoPage
    {
        $this->validate($data);

        $seoPageRequest = $data->getSeoPage();
        $Group = $this->getGroupById($seoPageRequest->getGroupId());

        $seoPage = new SeoPage();
        if ($seoPageRequest->getSort() !== null) {
            $seoPage->setSort($seoPageRequest->getSort());
        }

        if ($Group) {
            $seoPage->setGroup($Group);
        }

        $this->seoPageRepo->fill($seoPage, $seoPageRequest);
        $this->seoPageRepo->save($seoPage);

        $entity = $this->repository->new();
        $this->repository->fill($entity, $seoPage, $data);
        $this->repository->save($entity);

        return $entity;
    }

    /**
     * @param int $id
     * @param EntitySeoPageRequest $data
     * @return EntitySeoPage
     * @throws SeoPageNotFoundException
     * @throws ValidationException
     */
    public function update(int $id, EntitySeoPageRequest $data): EntitySeoPage
    {
        $this->validate($data, $id);

        $seoPageRequest = $data->getSeoPage();
        $Group = $this->getGroupById($seoPageRequest->getGroupId());

        if ($seoPageRequest->getId()) {
            $seoPage = $this->seoPageRepo->find($seoPageRequest->getId());
            if (!$seoPage) {
                throw new SeoPageNotFoundException();
            }
        } else {
            throw new SeoPageNotFoundException();
        }

        if ($seoPageRequest->getSort() !== null) {
            $seoPage->setSort($seoPageRequest->getSort());
        }

        if ($Group) {
            $seoPage->setGroup($Group);
        }

        $this->seoPageRepo->fill($seoPage, $seoPageRequest);
        $this->seoPageRepo->save($seoPage);

        $entity = $this->repository->findById($id);
        $this->repository->fill($entity, $seoPage, $data);
        $this->repository->save($entity);

        return $entity;
    }

    /**
     * @param int $id
     * @return void
     * @throws SeoPageNotFoundException
     */
    public function destroy(int $id): void
    {
        $entity = $this->repository->find($id);
        if (empty($entity)) {
            throw new SeoPageNotFoundException();
        }

        EntityManager::remove($entity);
        EntityManager::flush();
    }

    protected function getGroupById(?int $groupId): ?object
    {
        $Group = null;
        if ($groupId) {
            /** @var SeoPageGroupRepository $SeoPageGroupRepository */
            $SeoPageGroupRepository = app(SeoPageGroupRepository::class);

            $Group = $SeoPageGroupRepository->find($groupId);
        }

        return $Group;
    }
}
