<?php

namespace Combindma\Jumia\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromArray, WithHeadings
{
    protected $feed;

    public function __construct(array $feed)
    {
        $this->feed = $feed;
    }

    public function headings(): array
    {
        return [
            'Nom',
            'NameArMA',
            'Marque',
            'PrimaryCategory',
            'SalePrice',
            'SaleStartDate' => '',
            'SaleEndDate' => '',
            'TaxClass',
            'Prix',
            'SellerSku',
            'ParentSku' => '',
            'Quantity',
            'SeoIndex',
            'La Description',
            'DescriptionArMA',
            'ShortDescription',
            'ProductWeight',
            'Mots clés',
            'WarrantyDuration',
            'Variation' => '',
            'MainImage',
            'Image2',
            'Image3',
            'Image4',
            'Image5',
            'Image6',
            'Image7',
            'Image8'
        ];
    }

    public function array(): array
    {
        return $this->feed;
    }
}
