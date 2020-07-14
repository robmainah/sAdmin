<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class ProductsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'Code',
            'Category',
            'Title',
            'Price',
            'Quantity',
            'Created By',
            'Created At',
        ];
    }

    public function query()
    {
        return Product::select(['id', 'prod_code', 'category_id', 'title', 'price', 'quantity', 'created_by', 'created_at', 'updated_at'])->take(3);
        // return Product::select('id', 'prod_code', 'category_id.cat_name', 'title', 'price', 'quantity', 'created_by', 'created_at')->with('category')->get();
    }
    public function map($product): array
    {
        return [
            $product->prod_code,
            $product->category_id,
            $product->title ,
            $product->price,
            $product->quantity,
            $product->created_by,
            $product->created_at->format('Y-m-d'),
        ];
    }


}
