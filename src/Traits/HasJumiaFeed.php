<?php


namespace Combindma\Jumia\Traits;

trait HasJumiaFeed
{
    public function productFeed($name, $sku, $price, $quantity, $brand, $category, $description, $shortDescription)
    {
        $feed ['product'] = [
            'Name' => $name,
            'Description' => $description,
            'Brand' => ucwords($brand),
            'SellerSku' => $sku,
            'ParentSku' => '',
            'Price' => $price,
            'SalePrice' => '',
            'SaleStartDate' => '',
            'SaleEndDate' => '',
            'Quantity' => $quantity,
            'PrimaryCategory' => $category,
            'Categories' => '',
            'TaxClass' => 'zero',
            'ProductData' => [
                'NameArMA' => $name,
                'DescriptionArMA' => $description,
                'ProductWeight' => config('jumia.default_weight'),
                'ShortDescription' => $shortDescription,
                'WarrantyDuration' => config('jumia.default_warranty_duration'),
                'Keywords' => ucwords($brand),
                'SeoIndex' => true,
            ],
        ];

        return $feed;
    }

    public function imageFeed($sku, $featuredImage, $images)
    {
        //Make feed
        $feed ['ProductImage'] = [
            'SellerSku' => $sku,
            'Images' => [
                '__custom:Image:0' => $featuredImage,
            ],
        ];
        $loop = 1;
        foreach ($images as $media) {
            $feed ['ProductImage']['Images']['__custom:Image:' . $loop] = $media->getFullUrl();
            $loop++;
        }

        return $feed;
    }
}
