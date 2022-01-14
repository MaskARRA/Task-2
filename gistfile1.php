<?php

namespace Vendor\ModuleName\Model\ProductInformation;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Event\Manager;

/**
 * Class ProductInformation
 */
class ProductInformation
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var Manager
     */
    private $eventManager;

    /**
     * @var array
     */

    protected $productSku = [];

    /**
     * ProductInformation constructor.
     * @param array $productSku
     * @param ProductRepository $productRepository
     * @param Manager $eventManager
     */
    public function __construct(
        array $productSku,
        ProductRepository $productRepository,
        Manager $eventManager
    ) {
        $this->productSku = $productSku;
        $this->eventManager = $eventManager;
        $this->productRepository = $productRepository;

        $this->eventManager->dispatch(
            'product_data_load',

        //make a bracket here to load the product data and remove the $productSku and change to this
        //['productID' => $productLoad]    

            $productSku
        );
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductsData()
    {
        $productData = [];
        //productSkus is undefined change productSkus to $productLoad because it cannot loads the data from product_data_load
        foreach ($this->productSkus as $sku) {
            $product = $this->productRepository->get($sku);
            $productData[$product->getId()] = [
                'name' => $product->getName(),
                'price' => $product->getPrice()
            ];
        }

        return $productData;
    }
}