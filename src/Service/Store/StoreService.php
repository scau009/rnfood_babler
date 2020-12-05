<?php


namespace App\Service\Store;

use App\Entity\Company;
use App\Entity\Stores;
use App\Repository\StoresRepository;
use App\Utils\UploadHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class StoreService
{
    private EntityManagerInterface $entityManager;

    private StoresRepository $storeRepo;

    private UploadHelper $uploadHelper;

    public function __construct(EntityManagerInterface $entityManager,UploadHelper $uploadHelper)
    {
        $this->entityManager = $entityManager;
        $this->uploadHelper = $uploadHelper;
        $this->storeRepo = $entityManager->getRepository(Stores::class);
    }

    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $query = $this->storeRepo->findAll();
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function createStore(Request $request)
    {
        $fileBag = $request->files;
        $store = new Stores();
        if ($logoFile = $fileBag->get('logo_image_0')) {
            $logo = $this->uploadHelper->save($logoFile);
            $store->setLogo($logo);
        }else{
            throw new \Exception("请上传店铺 LOGO");
        }
        $collection = new ArrayCollection();
        for ($i = 0; $i < 9 ; $i++) {
            if ($bannerImageFile = $fileBag->get('banner_image_'.$i)) {
                $bannerImage = $this->uploadHelper->save($bannerImageFile);
                $collection->add($bannerImage);
            }
        }
        $companyId = $request->get('company_id');
        if (empty($companyId)) {
            throw new \Exception("请选择公司，如无公司选择请先创建公司");
        }
        $company = $this->entityManager->getRepository(Company::class)->find($companyId);
        $store->setCompany($company);
        $store->setBanners($collection->toArray());
        $store->setTitle($request->get('title'));
        $store->setLikes($request->get('likes'));
        $store->setMobile($request->get('mobile'));
        $store->setArea($request->get('area'));
        $store->setCity($request->get('city'));
        $store->setDayBegin($request->get('day_begin'));
        $store->setDayEnd($request->get('day_end'));
        $store->setLocationX($request->get('location_x'));
        $store->setLocationY($request->get('location_y'));
        $store->setProvince($request->get('province'));
        $store->setRoute($request->get('route'));
        $store->setScore($request->get('score'));
        $store->setTimeBegin($request->get('time_begin'));
        $store->setTimeEnd($request->get('time_end'));
        $store->setStatus($request->get('status'));
        $this->entityManager->persist($store);
        $this->entityManager->flush();
        return $store;
    }

    public function deleteOne(Stores $store)
    {
        if ($store->getProducts()->count() > 0 || $store->getCoupons()->count() > 0) {
            throw new \Exception("门店下还有商品或优惠券绑定，不能删除");
        }
        $this->entityManager->remove($store);
        $this->entityManager->flush();
    }

    public function editOne(Stores $store, Request $request)
    {
        $fileBag = $request->files;
        if ($fileBag->get('logo_image_0')) {
            $logoImage = $this->uploadHelper->save($fileBag->get('logo_image_0'));
        }else{
            $logoImage = $request->get('logo_image_text_0');
        }
        $store->setLogo($logoImage);
        $collection = new ArrayCollection($store->getBanners());
        for ($i = 0; $i < 9 ; $i++) {
            if ($bannerImageFile = $fileBag->get('banner_image_'.$i)) {
                $bannerImage = $this->uploadHelper->save($bannerImageFile);
                $collection->set($i, $bannerImage);
            }else{
                if ($oldBanner = $request->get('banner_image_text_'.$i)) {
                    $collection->set($i, $oldBanner);
                }
            }
        }
        $store->setBanners($collection->toArray());
        $companyId = $request->get('company_id');
        if (empty($companyId)) {
            throw new \Exception("请选择公司，如无公司选择请先创建公司");
        }
        $company = $this->entityManager->getRepository(Company::class)->find($companyId);
        $store->setCompany($company);
        $store->setTitle($request->get('title'));
        $store->setLikes($request->get('likes'));
        $store->setMobile($request->get('mobile'));
        $store->setArea($request->get('area'));
        $store->setCity($request->get('city'));
        $store->setDayBegin($request->get('day_begin'));
        $store->setDayEnd($request->get('day_end'));
        $store->setLocationX($request->get('location_x'));
        $store->setLocationY($request->get('location_y'));
        $store->setProvince($request->get('province'));
        $store->setRoute($request->get('route'));
        $store->setScore($request->get('score'));
        $store->setTimeBegin($request->get('time_begin'));
        $store->setTimeEnd($request->get('time_end'));
        $store->setStatus($request->get('status'));
        $this->entityManager->persist($store);
        $this->entityManager->flush();
        return $store;
    }
}