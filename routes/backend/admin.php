<?php

use App\Http\Controllers\Backend\DashboardController;

// All route names are prefixed with 'admin.'.
Route::redirect('/','/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

 //generals
  Route::get('generals','GeneralsController@index')->name('generals');
  Route::get('generals/{id}/edit/','GeneralsController@edit')->name('generals.edit');
  Route::post('generals/{id}/update','GeneralsController@update')->name('generals.update');
 //menu    
 Route::get('menus','MenusController@index')->name('menus');
 Route::get('menus/create','MenusController@create')->name('menus.create');
 Route::post('menus/store','MenusController@store')->name('menus.store');
 Route::get('menus/{id}/edit','MenusController@edit')->name('menus.edit');
 Route::get('menus/{id}/forceDelete','MenusController@forceDelete')->name('menus.forceDelete');
 Route::get('menus/{id}/destroy','MenusController@destroy')->name('menus.destroy');
 Route::get('menus/{id}/restore','MenusController@restore')->name('menus.restore');
 Route::post('menus/{id}/update','MenusController@update')->name('menus.update');

 //menu    
 Route::get('footer_menus','FooterMenuController@index')->name('footer_menus');
 Route::get('footer_menus/create','FooterMenuController@create')->name('footer_menus.create');
 Route::post('footer_menus/store','FooterMenuController@store')->name('footer_menus.store');
 Route::get('footer_menus/{id}/edit','FooterMenuController@edit')->name('footer_menus.edit');
 Route::get('footer_menus/{id}/forceDelete','FooterMenuController@forceDelete')->name('footer_menus.forceDelete');
 Route::get('footer_menus/{id}/destroy','FooterMenuController@destroy')->name('footer_menus.destroy');
 Route::get('footer_menus/{id}/restore','FooterMenuController@restore')->name('footer_menus.restore');
 Route::post('footer_menus/{id}/update','FooterMenuController@update')->name('footer_menus.update');
 
 //category    
 Route::get('categories','CategoryController@index')->name('categories');
 Route::get('categories/create','CategoryController@create')->name('categories.create');
 Route::post('categories/store','CategoryController@store')->name('categories.store');
 Route::get('categories/{id}/edit','CategoryController@edit')->name('categories.edit');
 Route::get('categories/{id}/forceDelete','CategoryController@forceDelete')->name('categories.forceDelete');
 Route::get('categories/{id}/destroy','CategoryController@destroy')->name('categories.destroy');
 Route::get('categories/{id}/restore','CategoryController@restore')->name('categories.restore');
 Route::post('categories/{id}/update','CategoryController@update')->name('categories.update');
 
 //brands    
 Route::get('brands','BrandController@index')->name('brands');
 Route::get('brands/create','BrandController@create')->name('brands.create');
 Route::post('brands/store','BrandController@store')->name('brands.store');
 Route::get('brands/{id}/edit','BrandController@edit')->name('brands.edit');
 Route::get('brands/{id}/forceDelete','BrandController@forceDelete')->name('brands.forceDelete');
 Route::get('brands/{id}/destroy','BrandController@destroy')->name('brands.destroy');
 Route::get('brands/{id}/restore','BrandController@restore')->name('brands.restore');
 Route::post('brands/{id}/update','BrandController@update')->name('brands.update');
 
 //products    
 Route::get('products','ProductController@index')->name('products');
 Route::get('products/create','ProductController@create')->name('products.create');
 Route::post('products/store','ProductController@store')->name('products.store');
 Route::get('products/{id}/edit','ProductController@edit')->name('products.edit');
 Route::get('products/{id}/forceDelete','ProductController@forceDelete')->name('products.forceDelete');
 Route::get('products/{id}/destroy','ProductController@destroy')->name('products.destroy');
 Route::get('products/{id}/restore','ProductController@restore')->name('products.restore');
 Route::post('products/{id}/update','ProductController@update')->name('products.update');
 Route::get('products/delete_single_photo/{id}','ProductController@deleteSinglePhoto')->name('products.delete_single_photo');
 
 
 //news    
 Route::get('news','NewsController@index')->name('news');
 Route::get('news/create','NewsController@create')->name('news.create');
 Route::post('news/store','NewsController@store')->name('news.store');
 Route::get('news/{id}/edit','NewsController@edit')->name('news.edit');
 Route::get('news/{id}/forceDelete','NewsController@forceDelete')->name('news.forceDelete');
 Route::get('news/{id}/destroy','NewsController@destroy')->name('news.destroy');
 Route::get('news/{id}/restore','NewsController@restore')->name('news.restore');
 Route::post('news/{id}/update','NewsController@update')->name('news.update');
 
 //news category    
 Route::get('news_categories','NewsCategoryController@index')->name('news_categories');
 Route::get('news_categories/create','NewsCategoryController@create')->name('news_categories.create');
 Route::post('news_categories/store','NewsCategoryController@store')->name('news_categories.store');
 Route::get('news_categories/{id}/edit','NewsCategoryController@edit')->name('news_categories.edit');
 Route::get('news_categories/{id}/forceDelete','NewsCategoryController@forceDelete')->name('news_categories.forceDelete');
 Route::get('news_categories/{id}/destroy','NewsCategoryController@destroy')->name('news_categories.destroy');
 Route::get('news_categories/{id}/restore','NewsCategoryController@restore')->name('news_categories.restore');
 Route::post('news_categories/{id}/update','NewsCategoryController@update')->name('news_categories.update');
 
 //slider    
 Route::get('sliders','SliderController@index')->name('sliders');
 Route::get('sliders/create','SliderController@create')->name('sliders.create');
 Route::post('sliders/store','SliderController@store')->name('sliders.store');
 Route::get('sliders/{id}/edit','SliderController@edit')->name('sliders.edit');
 Route::get('sliders/{id}/forceDelete','SliderController@forceDelete')->name('sliders.forceDelete');
 Route::get('sliders/{id}/destroy','SliderController@destroy')->name('sliders.destroy');
 Route::get('sliders/{id}/restore','SliderController@restore')->name('sliders.restore');
 Route::post('sliders/{id}/update','SliderController@update')->name('sliders.update');
 
 
 //main_page
 Route::get('main_page','MainPageController@getNewArrivals')->name('main_page');
 Route::get('main_page/store_items','MainPageController@storeItems')->name('main_page.store_items');
 Route::get('main_page/remove_on_arrivals/{u_id}','MainPageController@removeArrivals')->name('main_page.remove_arrivals');
 Route::get('main_page/remove_on_sale/{u_id}','MainPageController@removeSale')->name('main_page.remove_sale');
 Route::get('main_page/remove_on_main_page/{u_id}','MainPageController@removeCategory')->name('main_page.remove_category');
 Route::get('main_page/remove_on_main_page_brand/{u_id}','MainPageController@removeBrand')->name('main_page.remove_brand');
 
 Route::get('main_page/featured','MainPageController@getFeatured')->name('main_page.featured');
 Route::get('main_page/store_featured','MainPageController@storeFeatured')->name('main_page.store_featured');
 Route::get('main_page/remove_on_main_page_featured/{u_id}','MainPageController@removeFeatured')->name('main_page.remove_featured');
 
 Route::get('main_page/fluid_banner','MainPageController@getFluidBanner')->name('main_page.fluid_banner');
 Route::get('main_page/fluid_banner/edit/{u_id}','MainPageController@editFluidBanner')->name('main_page.fluid_banner.edit');
 Route::post('main_page/fluid_banner/update/{u_id}','MainPageController@updateFluidBanner')->name('main_page.fluid_banner.update');
 
 