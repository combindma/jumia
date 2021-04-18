<?php

namespace Combindma\Jumia\Http\Controllers;

use Combindma\Jumia\Exports\ProductsExport;
use Combindma\Jumia\Facades\Jumia;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\ArrayToXml\ArrayToXml;
use App\Models\Product;

class JumiaController extends Controller
{
    public function index()
    {
        return view('jumia::index');
    }

    public function testApi()
    {
        return Jumia::getJumiaProducts();
    }

    // generate jumiaFeed.xml that contains all products
    public function getProducts()
    {
        //Get all products
        $xmlFeed = ArrayToXml::convert($this->productsFeed(), ['rootElementName' => 'Request'], true, 'UTF-8', '1.0',);
        Storage::disk('root')->put('jumiaFeed.xml', $xmlFeed);
        return redirect('/jumiaFeed.xml');
    }

    // generate jumiaImagesFeed.xml that contains all products images
    public function getProductsImages()
    {
        //Get all products images
        $xmlFeed = ArrayToXml::convert($this->imagesFeed(), ['rootElementName' => 'Request'], true, 'UTF-8', '1.0',);
        Storage::disk('root')->put('jumiaImagesFeed.xml', $xmlFeed);
        return redirect('/jumiaImagesFeed.xml');
    }

    // send all products to Jumia Seller Center
    public function syncProducts()
    {
        Jumia::productUpdate($this->productsFeed());
        flash('Envoie effectué avec succès');
        return back();
    }

    // send all products images to Jumia Seller Center
    public function syncImages()
    {
        Jumia::productImage($this->imagesFeed());
        flash('Envoie effectué avec succès');
        return back();
    }

    // generate excel document that you can import in Jumia celler Center
    public function exportProducts()
    {
        return Excel::download(new ProductsExport($this->excelFeed()), 'products_' . now() . '.xlsx');
    }

    public function products()
    {
        return Product::active()
            ->whereNull('parent_id')
            ->where('price', '!=', 0)
            ->simple()
            ->with([
                'meta',
                'meta.brand',
                'categories',
                'variants',
                'attribute_values',
                'attribute_values.attribute',//important! to reduce queries
                'media',
            ])
            ->latest('id')
            ->get();
    }

    public function imagesFeed()
    {
        //Make feed
        $products = $this->products();
        $feed = [];
        $index = 0;
        foreach ($products as $product) {
            $feed ['__custom:ProductImage:' . $index] = [
                'SellerSku' => $product->sku,
                'Images' => [
                    '__custom:Image:0' => $product->featured_image_url()
                ]
            ];
            $loop = 1;
            foreach ($product->images() as $media) {
                $feed ['__custom:ProductImage:' . $index]['Images']['__custom:Image:' . $loop] = $media->getFullUrl();
                $loop++;
            }
            $index++;
        }
        return $feed;
    }

    public function productsFeed()
    {
        //Make feed
        $products = $this->products();
        $feed = [];
        $index = 0;
        foreach ($products as $product) {
            $name = $product->getJumiaName();
            $description = $product->getJumiaDescription();
            $feed ['__custom:Product:' . $index] = [
                'Name' => $name,
                'Description' => $description['description'],
                'Brand' => ucwords($product->brand_name),
                'SellerSku' => $product->sku,
                'ParentSku' => '',
                'Price' =>  $product->getJumiaPrice(),
                'SalePrice' => '',
                'SaleStartDate' => '',
                'SaleEndDate' => '',
                'Quantity' => $product->quantity,
                'PrimaryCategory' => optional($product->getCategoriesMeta())['jumia_id_category'],
                'Categories' => '',
                'TaxClass' => 'zero',
                'ProductData' => [
                    'NameArMA' => $name,
                    'DescriptionArMA' => $description['description'],
                    'ProductWeight' => config('jumia.default_weight'),
                    'ShortDescription' => $description['shortDescription'],
                    'WarrantyDuration' => config('jumia.default_warranty_duration'),
                    'Keywords' => ucwords($product->brand_name),
                    'SeoIndex' => true
                ],
            ];
            $index++;
        }
        return $feed;
    }

    public function excelFeed()
    {
        //Make feed
        $products = $this->products();
        $feed = [];
        $index = 0;
        foreach ($products as $product) {
            $name = $product->getJumiaName();
            $description = $product->getJumiaDescription();
            $feed ['__custom:Product:' . $index] = [
                'Nom' => $name,
                'NameArMA' => $name,
                'Marque' => ucwords($product->brand_name),
                'PrimaryCategory' => optional($product->getCategoriesMeta())['jumia_id_category'],
                'SalePrice' => '',
                'SaleStartDate' => '',
                'SaleEndDate' => '',
                'TaxClass' => 'zero',
                'Prix' => $product->getJumiaPrice(),
                'SellerSku' => $product->sku,
                'ParentSku' => '',
                'Quantity' => $product->quantity,
                'SeoIndex' => true,
                'Description' => $description['description'],
                'DescriptionArMA' => $description['description'],
                'ShortDescription' => $description['shortDescription'],
                'ProductWeight' => config('jumia.default_weight'),
                'Keywords' => ucwords($product->brand_name),
                'WarrantyDuration' => config('jumia.default_warranty_duration'),
                'Variation' => '',
                'MainImage' => $product->featured_image_url()
            ];
            $loop = 2;
            foreach ($product->images() as $media) {
                if ($loop <= 8) {
                    $feed ['__custom:Product:' . $index]['Image:' . $loop] = $media->getFullUrl();
                }
                $loop++;
            }
            $index++;
        }
        return $feed;
    }
}
