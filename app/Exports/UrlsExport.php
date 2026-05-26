<?php

namespace App\Exports;

use App\Models\ShortUrl;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UrlsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if(auth()->user()->isSuperAdmin()){
            return ShortUrl::with(['company','creator'])->get();
        }
        elseif(auth()->user()->isAdmin()){
            return ShortUrl::with('creator')->where('company_id',auth()->user()->company_id)->get();
        }
        else{
            return ShortUrl::where('created_by',auth()->user()->id)->get();
        }
    }

    public function headings(): array
    {
        if(auth()->user()->isSuperAdmin()){
            return [
                'ID',
                'Original URL',
                'Short Code',
                'Hits',
                'Company',
                'Created By',
                'Created At',
            ];
        }
        elseif(auth()->user()->isAdmin()){
            return [
                'ID',
                'Original URL',
                'Short Code',
                'Hits',
                'Created By',
                'Created At',
            ];
        }
        else{
            return [
                'ID',
                'Original URL',
                'Short Code',
                'Hits',
                'Created At',
            ];
        }
    }

    public function map($url): array
    {
        if(auth()->user()->isSuperAdmin()){
            return [
                $url->id,
                $url->original_url,
                $url->short_code,
                $url->hits ?? 0,
                $url->company?->name,
                $url->creator?->name,
                $url->created_at,
            ];
        }
        elseif(auth()->user()->isAdmin()){
            return [
                $url->id,
                $url->original_url,
                $url->short_code,
                $url->hits ?? 0,
                $url->creator?->name,
                $url->created_at,
            ];
        }
        else{
            return [
                $url->id,
                $url->original_url,
                $url->short_code,
                $url->hits ?? 0,
                $url->created_at,
            ];
        }
    }
}
