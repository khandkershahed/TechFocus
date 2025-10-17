<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Catalog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\CatalogRequest;
use App\Models\Admin\CatalogAttachment;
use App\Models\Admin\Company;
use App\Models\Admin\Industry;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 public function index()
{
    $catalogs = Catalog::with(['attachments'])->latest()->get();
    
    // Debug: Check what's in the relationship arrays
    // foreach ($catalogs as $catalog) {
    //     Log::info("Catalog ID: {$catalog->id}");
    //     Log::info("Category: {$catalog->category}");
    //     Log::info("Brand IDs: " . json_encode($catalog->brand_id));
    //     Log::info("Product IDs: " . json_encode($catalog->product_id));
    //     Log::info("Industry IDs: " . json_encode($catalog->industry_id));
    //     Log::info("Company IDs: " . json_encode($catalog->company_id));
        
    //     // Test the relationships
    // //     if ($catalog->category == 'brand') {
    // //         Log::info("Brands count: " . $catalog->brands()->count());
    // //     }
    //  }
    
    return view('admin.pages.catalog.index', [
        'catalogs' => $catalogs,
    ]);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.catalog.create', [
            'brands' => Brand::get(['id', 'title']),
            'products' => Product::get(['id', 'name']),
            'industries' => Industry::get(['id', 'name']),
            'companies' => Company::get(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $catalogData = [
                'category'            => $request->input('category'),
                'brand_id'            => json_encode($request->input('brand_id', [])),
                'product_id'          => json_encode($request->input('product_id', [])),
                'industry_id'         => json_encode($request->input('industry_id', [])),
                'solution_id'         => json_encode($request->input('solution_id', [])),
                'company_id'          => json_encode($request->input('company_id', [])),
                'name'                => $request->input('name'),
                'slug'                => Str::slug($request->input('name')),
                'page_number'         => $request->input('page_number'),
                'description'         => $request->input('description'),
                'company_button_name' => $request->input('company_button_name'),
                'company_button_link' => $request->input('company_button_link'),
                'created_by'          => Auth::id(),
            ];

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = 'thumbnail_' . time() . '_' . uniqid() . '.' . $thumbnail->getClientOriginalExtension();
                
                $thumbnailPath = storage_path('app/public/catalog/thumbnail');
                if (!file_exists($thumbnailPath)) {
                    mkdir($thumbnailPath, 0755, true);
                }
                
                $thumbnail->move($thumbnailPath, $thumbnailName);
                $catalogData['thumbnail'] = $thumbnailName;
            }

            // Handle document upload
            if ($request->hasFile('document')) {
                $document = $request->file('document');
                $documentName = 'document_' . time() . '_' . uniqid() . '.' . $document->getClientOriginalExtension();
                
                $documentPath = storage_path('app/public/catalog/document');
                if (!file_exists($documentPath)) {
                    mkdir($documentPath, 0755, true);
                }
                
                $document->move($documentPath, $documentName);
                $catalogData['document'] = $documentName;
            }

            // Create the catalog
            $catalog = Catalog::create($catalogData);

            // Handle page images from repeater
            if ($request->has('kt_docs_repeater_advanced')) {
                foreach ($request->kt_docs_repeater_advanced as $index => $item) {
                    $attachmentData = [
                        'catalog_id'       => $catalog->id,
                        'page_description' => $item['description'] ?? null,
                        'page_link'        => $item['page_link'] ?? null,
                        'button_name'      => $item['button_name'] ?? null,
                        'button_link'      => $item['button_link'] ?? null,
                    ];

                    // Handle page image
                    if (isset($item['page_image']) && $item['page_image'] instanceof UploadedFile) {
                        $pageImage = $item['page_image'];
                        $pageImageName = 'page_' . time() . '_' . $index . '.' . $pageImage->getClientOriginalExtension();
                        
                        $pageImagePath = storage_path('app/public/catalog/document');
                        if (!file_exists($pageImagePath)) {
                            mkdir($pageImagePath, 0755, true);
                        }
                        
                        $pageImage->move($pageImagePath, $pageImageName);
                        $attachmentData['page_image'] = $pageImageName;
                    }

                    CatalogAttachment::create($attachmentData);
                }
            }

            DB::commit();
            
            return redirect()->route('admin.catalog.index')
                ->with('success', 'Catalog created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Catalog creation failed: ' . $e->getMessage());
            Log::error('Full error: ' . $e->getFile() . ':' . $e->getLine() . ' - ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create catalog: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $catalog = Catalog::with(['attachments'])->findOrFail($id);
            
        return view('admin.pages.catalog.show', compact('catalog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $catalog = Catalog::with('attachments')->findOrFail($id);
        
        return view('admin.pages.catalog.edit', [
            'catalog' => $catalog,
            'brands' => Brand::get(['id', 'title']),
            'products' => Product::get(['id', 'name']),
            'industries' => Industry::get(['id', 'name']),
            'companies' => Company::get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatalogRequest $request, $id)
    {
        DB::beginTransaction();
        
        try {
            $catalog = Catalog::findOrFail($id);
            
            $catalogData = [
                'category'            => $request->input('category'),
                'brand_id'            => json_encode($request->input('brand_id', [])),
                'product_id'          => json_encode($request->input('product_id', [])),
                'industry_id'         => json_encode($request->input('industry_id', [])),
                'solution_id'         => json_encode($request->input('solution_id', [])),
                'company_id'          => json_encode($request->input('company_id', [])),
                'name'                => $request->input('name'),
                'slug'                => Str::slug($request->input('name')),
                'page_number'         => $request->input('page_number'),
                'description'         => $request->input('description'),
                'company_button_name' => $request->input('company_button_name'),
                'company_button_link' => $request->input('company_button_link'),
                'updated_by'          => Auth::id(),
            ];

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($catalog->thumbnail) {
                    $oldThumbnailPath = storage_path('app/public/catalog/thumbnail/' . $catalog->thumbnail);
                    if (file_exists($oldThumbnailPath)) {
                        unlink($oldThumbnailPath);
                    }
                }
                
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = 'thumbnail_' . time() . '_' . uniqid() . '.' . $thumbnail->getClientOriginalExtension();
                
                $thumbnailPath = storage_path('app/public/catalog/thumbnail');
                if (!file_exists($thumbnailPath)) {
                    mkdir($thumbnailPath, 0755, true);
                }
                
                $thumbnail->move($thumbnailPath, $thumbnailName);
                $catalogData['thumbnail'] = $thumbnailName;
            }

            // Handle document upload
            if ($request->hasFile('document')) {
                // Delete old document
                if ($catalog->document) {
                    $oldDocumentPath = storage_path('app/public/catalog/document/' . $catalog->document);
                    if (file_exists($oldDocumentPath)) {
                        unlink($oldDocumentPath);
                    }
                }
                
                $document = $request->file('document');
                $documentName = 'document_' . time() . '_' . uniqid() . '.' . $document->getClientOriginalExtension();
                
                $documentPath = storage_path('app/public/catalog/document');
                if (!file_exists($documentPath)) {
                    mkdir($documentPath, 0755, true);
                }
                
                $document->move($documentPath, $documentName);
                $catalogData['document'] = $documentName;
            }

            // Update the catalog
            $catalog->update($catalogData);

            // Handle page images from repeater - delete existing and create new
            if ($request->has('kt_docs_repeater_advanced')) {
                // Delete existing attachments
                foreach ($catalog->attachments as $attachment) {
                    // Delete attachment image if exists
                    if ($attachment->page_image) {
                        $oldPageImagePath = storage_path('app/public/catalog/document/' . $attachment->page_image);
                        if (file_exists($oldPageImagePath)) {
                            unlink($oldPageImagePath);
                        }
                    }
                    $attachment->delete();
                }

                // Create new attachments
                foreach ($request->kt_docs_repeater_advanced as $index => $item) {
                    $attachmentData = [
                        'catalog_id'       => $catalog->id,
                        'page_description' => $item['description'] ?? null,
                        'page_link'        => $item['page_link'] ?? null,
                        'button_name'      => $item['button_name'] ?? null,
                        'button_link'      => $item['button_link'] ?? null,
                    ];

                    // Handle page image
                    if (isset($item['page_image']) && $item['page_image'] instanceof UploadedFile) {
                        $pageImage = $item['page_image'];
                        $pageImageName = 'page_' . time() . '_' . $index . '.' . $pageImage->getClientOriginalExtension();
                        
                        $pageImagePath = storage_path('app/public/catalog/document');
                        if (!file_exists($pageImagePath)) {
                            mkdir($pageImagePath, 0755, true);
                        }
                        
                        $pageImage->move($pageImagePath, $pageImageName);
                        $attachmentData['page_image'] = $pageImageName;
                    }

                    CatalogAttachment::create($attachmentData);
                }
            }

            DB::commit();
            
            return redirect()->route('admin.catalog.index')
                ->with('success', 'Catalog updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Catalog update failed: ' . $e->getMessage());
            Log::error('Full error: ' . $e->getFile() . ':' . $e->getLine() . ' - ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update catalog: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $catalog = Catalog::with('attachments')->findOrFail($id);

            // Delete thumbnail
            if ($catalog->thumbnail) {
                $thumbnailPath = storage_path('app/public/catalog/thumbnail/' . $catalog->thumbnail);
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                }
            }

            // Delete document
            if ($catalog->document) {
                $documentPath = storage_path('app/public/catalog/document/' . $catalog->document);
                if (file_exists($documentPath)) {
                    unlink($documentPath);
                }
            }

            // Delete attachment images
            foreach ($catalog->attachments as $attachment) {
                if ($attachment->page_image) {
                    $pageImagePath = storage_path('app/public/catalog/document/' . $attachment->page_image);
                    if (file_exists($pageImagePath)) {
                        unlink($pageImagePath);
                    }
                }
                $attachment->delete();
            }

            // Delete the catalog
            $catalog->delete();

            DB::commit();
            
            return redirect()->route('admin.catalog.index')
                ->with('success', 'Catalog deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Catalog deletion failed: ' . $e->getMessage());
            Log::error('Full error: ' . $e->getFile() . ':' . $e->getLine() . ' - ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Failed to delete catalog: ' . $e->getMessage());
        }
    }
}