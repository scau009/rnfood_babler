<?php


namespace App\Service\Product;

use App\Entity\Products;
use App\Entity\ProductTags;
use App\Entity\Stores;
use App\Repository\ProductsRepository;
use App\Repository\ProductTagsRepository;
use App\Repository\StoresRepository;
use App\Service\EntityService;
use App\Utils\UploadHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class ProductService
{
    private EntityManagerInterface $entityManager;

    private UploadHelper $uploadHelper;

    private StoresRepository $storesRepository;

    private ProductTagsRepository $productTagsRepo;

    private ProductsRepository $productRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                UploadHelper $uploadHelper)
    {
        $this->entityManager = $entityManager;
        $this->uploadHelper = $uploadHelper;
        $this->storesRepository = $entityManager->getRepository(Stores::class);
        $this->productRepository = $entityManager->getRepository(Products::class);
        $this->productTagsRepo = $entityManager->getRepository(ProductTags::class);
    }

    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $query = $this->productRepository->findAll();
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function createProduct(Request $request)
    {
        $product = new Products();
        $fileBag = $request->files;
        $product->setTitle($request->get('title'));
        $headImage = $this->uploadHelper->save($fileBag->get('head_image_0'));
        $product->setHeadImage($headImage);
        $collection = new ArrayCollection();
        for ($i = 0; $i < 9 ; $i++) {
            if ($bannerImageFile = $fileBag->get('banner_image_'.$i)) {
                $bannerImage = $this->uploadHelper->save($bannerImageFile);
                $collection->add($bannerImage);
            }
        }
        $product->setBanners($collection->toArray());
        $product->setPrice($request->get('price'));
        $product->setPriceWas($request->get('price_was'));
        $product->setDescription($request->get('description'));
        $product->setStatus($request->get('status'));
        $product->setQuantity($request->get('quantity'));
        $product->setLikes($request->get('likes'));
        $product->setSoldCount($request->get('sold_count'));
        $product->setEndTime(new \DateTime($request->get('end_time')));
        $storeIds = $request->get('stores');
        $stores = $this->storesRepository->getByStoreIds($storeIds);
        /** @var Stores $store */
        foreach ($stores as $store) {
            $product->addStore($store);
        }
        $tagIds = $request->get('tags');
        $tags = $this->productTagsRepo->findByIds($tagIds);
        /** @var ProductTags $tag */
        foreach ($tags as $tag) {
            $product->addTag($tag);
        }
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product;
    }

    public function deleteOne(Products $products)
    {
        $this->entityManager->remove($products);
        $this->entityManager->flush();
    }

    public function editOne(Products $product, Request $request)
    {
        $fileBag = $request->files;
        $product->setTitle($request->get('title'));
        if ($fileBag->get('head_image_0')) {
            $headImage = $this->uploadHelper->save($fileBag->get('head_image_0'));
        }else{
            $headImage = $request->get('head_image_text_0');
        }
        $product->setHeadImage($headImage);
        $collection = new ArrayCollection($product->getBanners());
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
        $product->setBanners($collection->toArray());
        $product->setPrice($request->get('price'));
        $product->setPriceWas($request->get('price_was'));
        $product->setDescription($request->get('description'));
        $product->setStatus($request->get('status'));
        $product->setQuantity($request->get('quantity'));
        $product->setLikes($request->get('likes'));
        $product->setSoldCount($request->get('sold_count'));
        $product->setEndTime(new \DateTime($request->get('end_time')));
        $storeIds = $request->get('stores');
        $stores = $this->storesRepository->getByStoreIds($storeIds);
        foreach ($product->getStores() as $productStore) {
            if (!in_array($productStore->getId(),$storeIds)) {
                $product->getStores()->removeElement($productStore);
            }
        }
        /** @var Stores $store */
        foreach ($stores as $store) {
            if (!$product->getStores()->contains($store)) {
                $product->addStore($store);
            }
        }
        $tagIds = $request->get('tags');
        $tags = $this->productTagsRepo->findByIds($tagIds);
        foreach ($product->getTags() as $productTag) {
            if (!in_array($productTag->getId(),$tagIds)) {
                $product->getTags()->removeElement($productTag);
            }
        }
        /** @var ProductTags $tag */
        foreach ($tags as $tag) {
            $product->addTag($tag);
        }
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product;
    }
}