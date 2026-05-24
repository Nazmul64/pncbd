<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Generalsetting;
use Illuminate\Http\Request;

use App\Models\Websitefavicon;

class LandingPageController extends Controller
{
    public function show($slug)
    {
        $productIds = \App\Models\Product::where('slug', $slug)->pluck('id')->toArray();

        $landing = LandingPage::where('status', true)
            ->where(function($query) use ($slug, $productIds) {
                $query->where('slug', $slug);
                
                if (!empty($productIds)) {
                    $query->orWhereIn('product_id', $productIds);
                    foreach ($productIds as $pId) {
                        $query->orWhereJsonContains('product_ids', (int)$pId)
                              ->orWhereJsonContains('product_ids', (string)$pId);
                    }
                }
            })->firstOrFail();

        // Resolve product from relationship or product_ids array
        $product = $landing->product;
        if (!$product && $landing->product_ids && count($landing->product_ids) > 0) {
            $product = \App\Models\Product::find($landing->product_ids[0]);
        }

        // Dynamically set relationship so views calling $landing->product work perfectly
        if ($product) {
            $landing->setRelation('product', $product);
        }

        // Dynamic Canonical Redirect: If page has a product with a valid slug, and requested slug is different, redirect!
        if ($product && $product->slug && $slug !== $product->slug) {
            return redirect()->route('landing.show', $product->slug);
        }

        $websetting = Generalsetting::first();
        $favicon = Websitefavicon::first();
        $shippingCharges = \App\Models\ShippingCharge::active()->get();

        // SEO Title: Use product name if available, else page title
        $pageTitle = ($product && $product->name) ? $product->name : $landing->title;
        
        // Render the chosen template
        // Templates should be in resources/views/frontend/landing/
        $viewPath = "frontend.landing." . $landing->template_name;
        
        if (!view()->exists($viewPath)) {
            // Fallback to default if template doesn't exist
            $viewPath = "frontend.landing.landing-1";
        }

        return view($viewPath, compact('landing', 'websetting', 'favicon', 'shippingCharges', 'pageTitle'));
    }
}
